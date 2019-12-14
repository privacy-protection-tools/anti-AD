<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * DNS Library for handling lookups and updates. 
 *
 * PHP Version 5
 *
 * Copyright (c) 2010, Mike Pultz <mike@mikepultz.com>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name of Mike Pultz nor the names of his contributors 
 *     may be used to endorse or promote products derived from this 
 *     software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRIC
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @category  Networking
 * @package   Net_DNS2
 * @author    Mike Pultz <mike@mikepultz.com>
 * @copyright 2010 Mike Pultz <mike@mikepultz.com>
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   SVN: $Id$
 * @link      http://pear.php.net/package/Net_DNS2
 * @since     File available since Release 0.6.0
 *
 */

/**
 * The main dynamic DNS notifier class.
 *
 * This class provices functions to handle DNS notify requests as defined by RFC 1996.
 *
 * This is separate from the Net_DNS2_Resolver class, as while the underlying
 * protocol is the same, the functionality is completely different.
 *
 * Generally, query (recursive) lookups are done against caching server, while
 * notify requests are done against authoratative servers.
 * 
 * @category Networking
 * @package  Net_DNS2
 * @author   Balázs Kalmár <hunbalazs@protonmail.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link     http://pear.php.net/package/Net_DNS2
 * @see      Net_DNS2
 *
 */
class Net_DNS2_Notifier extends Net_DNS2
{
    /*
     * a Net_DNS2_Packet_Request object used for the notify request
     */
    private $_packet;

    /**
     * Constructor - builds a new Net_DNS2_Notifier objected used for doing 
     * DNS notification for a changed zone
     *
     * @param string $zone    the domain name to use for DNS updates
     * @param mixed  $options an array of config options or null
     *
     * @throws Net_DNS2_Exception
     * @access public
     *
     */
    public function __construct($zone, array $options = null)
    {
        parent::__construct($options);

        //
        // create the packet
        //
        $this->_packet = new Net_DNS2_Packet_Request(
            strtolower(trim($zone, " \n\r\t.")), 'SOA', 'IN'
        );

        //
        // make sure the opcode on the packet is set to NOTIFY
        //
        $this->_packet->header->opcode = Net_DNS2_Lookups::OPCODE_NOTIFY;
    }

    /**
     * checks that the given name matches the name for the zone we're notifying
     *
     * @param string $name The name to be checked.
     *
     * @return boolean
     * @throws Net_DNS2_Exception
     * @access private
     *
     */
    private function _checkName($name)
    {
        if (!preg_match('/' . $this->_packet->question[0]->qname . '$/', $name)) {
            
            throw new Net_DNS2_Exception(
                'name provided (' . $name . ') does not match zone name (' .
                $this->_packet->question[0]->qname . ')',
                Net_DNS2_Lookups::E_PACKET_INVALID
            );
        }
    
        return true;
    }

    /**
     *   3.7 - Add RR to notify
     *
     * @param Net_DNS2_RR $rr the Net_DNS2_RR object to be sent in the notify message
     *
     * @return boolean
     * @throws Net_DNS2_Exception
     * @access public
     *
     */
    public function add(Net_DNS2_RR $rr)
    {
        $this->_checkName($rr->name);
        //
        // add the RR to the "notify" section
        //
        if (!in_array($rr, $this->_packet->answer)) {
            $this->_packet->answer[] = $rr;
        }
        return true;
    }

    /**
     * add a signature to the request for authentication 
     *
     * @param string $keyname   the key name to use for the TSIG RR
     * @param string $signature the key to sign the request.
     *
     * @return     boolean
     * @access     public
     * @see        Net_DNS2::signTSIG()
     * @deprecated function deprecated in 1.1.0
     *
     */
    public function signature($keyname, $signature, $algorithm = Net_DNS2_RR_TSIG::HMAC_MD5)
    {
        return $this->signTSIG($keyname, $signature, $algorithm);
    }

    /**
     * returns the current internal packet object.
     *
     * @return Net_DNS2_Packet_Request
     * @access public
     #
     */
    public function packet()
    {
        //
        // take a copy
        //
        $p = $this->_packet;

        //
        // check for an authentication method; either TSIG or SIG
        //
        if (   ($this->auth_signature instanceof Net_DNS2_RR_TSIG) 
            || ($this->auth_signature instanceof Net_DNS2_RR_SIG)
        ) {
            $p->additional[] = $this->auth_signature;
        }

        //
        // update the counts
        //
        $p->header->qdcount = count($p->question);
        $p->header->ancount = count($p->answer);
        $p->header->nscount = count($p->authority);
        $p->header->arcount = count($p->additional);

        return $p;
    }

    /**
     * executes the notify request
     *
     * @param Net_DNS2_Packet_Response &$response ref to the response object
     *
     * @return boolean
     * @throws Net_DNS2_Exception
     * @access public
     *
     */
    public function notify(&$response = null)
    {
        //
        // check for an authentication method; either TSIG or SIG
        //
        if (   ($this->auth_signature instanceof Net_DNS2_RR_TSIG) 
            || ($this->auth_signature instanceof Net_DNS2_RR_SIG)
        ) {
            $this->_packet->additional[] = $this->auth_signature;
        }

        //
        // update the counts
        //
        $this->_packet->header->qdcount = count($this->_packet->question);
        $this->_packet->header->ancount = count($this->_packet->answer);
        $this->_packet->header->nscount = count($this->_packet->authority);
        $this->_packet->header->arcount = count($this->_packet->additional);

        //
        // make sure we have some data to send
        //
        if ($this->_packet->header->qdcount == 0) {
            throw new Net_DNS2_Exception(
                'empty headers- nothing to send!',
                Net_DNS2_Lookups::E_PACKET_INVALID
            );
        }

        //
        // send the packet and get back the response
        //
        $response = $this->sendPacket($this->_packet, $this->use_tcp);

        //
        // clear the internal packet so if we make another request, we don't have
        // old data being sent.
        //
        $this->_packet->reset();

        //
        // for notifies, we just need to know it worked- we don't actualy need to
        // return the response object
        //
        return true;
    }
}

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */
?>

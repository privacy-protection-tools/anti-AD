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
 * This class handles building new DNS response packets; it parses binary packed
 * packets that come off the wire
 *
 * @category Networking
 * @package  Net_DNS2
 * @author   Mike Pultz <mike@mikepultz.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link     http://pear.php.net/package/Net_DNS2
 * @see      Net_DNS2_Packet
 * 
 */
class Net_DNS2_Packet_Response extends Net_DNS2_Packet
{
    /*
     * The name servers that this response came from
     */
    public $answer_from;

    /*
     * The socket type the answer came from (TCP/UDP)
     */
    public $answer_socket_type;

    /*
     * The query response time in microseconds
     */
    public $response_time = 0;

    /**
     * Constructor - builds a new Net_DNS2_Packet_Response object
     *
     * @param string  $data binary DNS packet
     * @param integer $size the length of the DNS packet
     *
     * @throws Net_DNS2_Exception
     * @access public
     *
     */
    public function __construct($data, $size)
    {
        $this->set($data, $size);
    }

    /**
     * builds a new Net_DNS2_Packet_Response object
     *
     * @param string  $data binary DNS packet
     * @param integer $size the length of the DNS packet
     *
     * @return boolean
     * @throws Net_DNS2_Exception
     * @access public
     *
     */
    public function set($data, $size)
    {
        //
        // store the full packet
        //
        $this->rdata    = $data;
        $this->rdlength = $size;

        //
        // parse the header
        // 
        // we don't bother checking the size earlier, because the first thing the
        // header class does, is check the size and throw and exception if it's
        // invalid.
        //
        $this->header = new Net_DNS2_Header($this);

        //
        // if the truncation bit is set, then just return right here, because the
        // rest of the packet is probably empty; and there's no point in processing
        // anything else.
        //
        // we also don't need to worry about checking to see if the the header is 
        // null or not, since the Net_DNS2_Header() constructor will throw an 
        // exception if the packet is invalid.
        //
        if ($this->header->tc == 1) {

            return false;
        }

        //
        // parse the questions
        //
        for ($x = 0; $x < $this->header->qdcount; ++$x) {

            $this->question[$x] = new Net_DNS2_Question($this);
        }

        //
        // parse the answers
        //
        for ($x = 0; $x < $this->header->ancount; ++$x) {

            $o = Net_DNS2_RR::parse($this);
            if (!is_null($o)) {

                $this->answer[] = $o;
            }
        } 

        //
        // parse the authority section
        //
        for ($x = 0; $x < $this->header->nscount; ++$x) {

            $o = Net_DNS2_RR::parse($this);
            if (!is_null($o)) {

                $this->authority[] = $o;  
            }
        }

        //
        // parse the additional section
        //
        for ($x = 0; $x < $this->header->arcount; ++$x) {

            $o = Net_DNS2_RR::parse($this);
            if (!is_null($o)) {

                $this->additional[] = $o; 
            }
        }

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

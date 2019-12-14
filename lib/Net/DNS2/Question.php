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
 * This class handles parsing and constructing the question sectino of DNS
 * packets.
 *
 * This is referred to as the "zone" for update per RFC2136
 *
 * DNS question format - RFC1035 section 4.1.2
 *
 *      0  1  2  3  4  5  6  7  8  9  0  1  2  3  4  5
 *    +--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+
 *    |                                               |
 *    /                     QNAME                     /
 *    /                                               /
 *    +--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+
 *    |                     QTYPE                     |
 *    +--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+
 *    |                     QCLASS                    |
 *    +--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+
 *
 * @category Networking
 * @package  Net_DNS2
 * @author   Mike Pultz <mike@mikepultz.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link     http://pear.php.net/package/Net_DNS2
 * @see      Net_DNS2_Packet
 *
 */
class Net_DNS2_Question
{
    /*
     * The name of the question
     *
     * referred to as "zname" for updates per RFC2136
     *
     */
    public $qname;

    /*
     * The RR type for the questino
     *
     * referred to as "ztype" for updates per RFC2136
     *
     */
    public $qtype;
    
    /*
     * The RR class for the questino
     *
     * referred to as "zclass" for updates per RFC2136
     *
     */
    public $qclass;

    /**
     * Constructor - builds a new Net_DNS2_Question object
     *
     * @param mixed &$packet either a Net_DNS2_Packet object, or null to 
     *                       build an empty object
     *
     * @throws Net_DNS2_Exception
     * @access public
     *
     */
    public function __construct(Net_DNS2_Packet &$packet = null)
    {
        if (!is_null($packet)) {

            $this->set($packet);
        } else {

            $this->qname    = '';
            $this->qtype    = 'A';
            $this->qclass   = 'IN';
        }
    }

    /**
     * magic __toString() function to return the Net_DNS2_Question object as a string
     *
     * @return string
     * @access public
     *
     */
    public function __toString()
    {
        return ";;\n;; Question:\n;;\t " . $this->qname . '. ' . 
            $this->qtype . ' ' . $this->qclass . "\n";
    }

    /**
     * builds a new Net_DNS2_Header object from a Net_DNS2_Packet object
     *
     * @param Net_DNS2_Packet &$packet a Net_DNS2_Packet object
     *
     * @return boolean
     * @throws Net_DNS2_Exception
     * @access public
     *
     */
    public function set(Net_DNS2_Packet &$packet)
    {
        //
        // expand the name
        //
        $this->qname = $packet->expand($packet, $packet->offset);
        if ($packet->rdlength < ($packet->offset + 4)) {

            throw new Net_DNS2_Exception(
                'invalid question section: to small',
                Net_DNS2_Lookups::E_QUESTION_INVALID
            );
        }

        //
        // unpack the type and class
        //
        $type   = ord($packet->rdata[$packet->offset++]) << 8 | 
            ord($packet->rdata[$packet->offset++]);
        $class  = ord($packet->rdata[$packet->offset++]) << 8 | 
            ord($packet->rdata[$packet->offset++]);

        //
        // validate it
        //
        $type_name  = Net_DNS2_Lookups::$rr_types_by_id[$type];
        $class_name = Net_DNS2_Lookups::$classes_by_id[$class];

        if ( (!isset($type_name)) || (!isset($class_name)) ) {

            throw new Net_DNS2_Exception(
                'invalid question section: invalid type (' . $type . 
                ') or class (' . $class . ') specified.',
                Net_DNS2_Lookups::E_QUESTION_INVALID
            );
        }

        //
        // store it
        //
        $this->qtype     = $type_name;
        $this->qclass    = $class_name;

        return true;
    }

    /**
     * returns a binary packed Net_DNS2_Question object
     *
     * @param Net_DNS2_Packet &$packet the Net_DNS2_Packet object this question is 
     *                                 part of. This needs to be passed in so that
     *                                 the compressed qname value can be packed in
     *                                 with the names of the other parts of the 
     *                                 packet.
     *
     * @return string
     * @throws Net_DNS2_Exception
     * @access public
     *
     */
    public function get(Net_DNS2_Packet &$packet)
    {
        //
        // validate the type and class
        //
        $type  = Net_DNS2_Lookups::$rr_types_by_name[$this->qtype];
        $class = Net_DNS2_Lookups::$classes_by_name[$this->qclass];

        if ( (!isset($type)) || (!isset($class)) ) {

            throw new Net_DNS2_Exception(
                'invalid question section: invalid type (' . $this->qtype . 
                ') or class (' . $this->qclass . ') specified.',
                Net_DNS2_Lookups::E_QUESTION_INVALID
            );
        }

        $data = $packet->compress($this->qname, $packet->offset);

        $data .= chr($type >> 8) . chr($type) . chr($class >> 8) . chr($class);
        $packet->offset += 4;

        return $data;
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

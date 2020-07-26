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
 * DNS Packet Header class
 *
 * This class handles parsing and constructing DNS Packet Headers as defined
 * by section 4.1.1 of RFC1035.
 * 
 *  DNS header format - RFC1035 section 4.1.1
 *  DNS header format - RFC4035 section 3.2
 *
 *      0  1  2  3  4  5  6  7  8  9  0  1  2  3  4  5
 *    +--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+
 *    |                      ID                       |
 *    +--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+
 *    |QR|   Opcode  |AA|TC|RD|RA| Z|AD|CD|   RCODE   |
 *    +--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+
 *    |                    QDCOUNT                    |
 *    +--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+
 *    |                    ANCOUNT                    |
 *    +--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+
 *    |                    NSCOUNT                    |
 *    +--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+
 *    |                    ARCOUNT                    |
 *    +--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+
 *
 * @category Networking
 * @package  Net_DNS2
 * @author   Mike Pultz <mike@mikepultz.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link     http://pear.php.net/package/Net_DNS2
 *
 */
class Net_DNS2_Header
{
    public $id;         // 16 bit - identifier
    public $qr;         //  1 bit - 0 = query, 1 = response
    public $opcode;     //  4 bit - op code
    public $aa;         //  1 bit - Authoritative Answer
    public $tc;         //  1 bit - TrunCation
    public $rd;         //  1 bit - Recursion Desired
    public $ra;         //  1 bit - Recursion Available
    public $z;          //  1 bit - Reserved
    public $ad;         //  1 bit - Authentic Data (RFC4035)
    public $cd;         //  1 bit - Checking Disabled (RFC4035)
    public $rcode;      //  4 bit - Response code
    public $qdcount;    // 16 bit - entries in the question section
    public $ancount;    // 16 bit - resource records in the answer section
    public $nscount;    // 16 bit - name server rr in the authority records section
    public $arcount;    // 16 bit - rr's in the additional records section

    /**
     * Constructor - builds a new Net_DNS2_Header object
     *
     * @param mixed &$packet either a Net_DNS2_Packet object or null
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

            $this->id       = $this->nextPacketId();
            $this->qr       = Net_DNS2_Lookups::QR_QUERY;
            $this->opcode   = Net_DNS2_Lookups::OPCODE_QUERY;
            $this->aa       = 0;
            $this->tc       = 0;
            $this->rd       = 1;
            $this->ra       = 0;
            $this->z        = 0;
            $this->ad       = 0;
            $this->cd       = 0;
            $this->rcode    = Net_DNS2_Lookups::RCODE_NOERROR;
            $this->qdcount  = 1;
            $this->ancount  = 0;
            $this->nscount  = 0;
            $this->arcount  = 0;
        }
    }

    /**
     * returns the next available packet id
     *
     * @return    integer
     * @access    public
     *
     */
    public function nextPacketId()
    {
        if (++Net_DNS2_Lookups::$next_packet_id > 65535) {

            Net_DNS2_Lookups::$next_packet_id = 1;
        }

        return Net_DNS2_Lookups::$next_packet_id;
    }

    /**
     * magic __toString() method to return the header as a string
     *
     * @return    string
     * @access    public
     *
     */
    public function __toString()
    {
        $output = ";;\n;; Header:\n";

        $output .= ";;\t id         = " . $this->id . "\n";
        $output .= ";;\t qr         = " . $this->qr . "\n";
        $output .= ";;\t opcode     = " . $this->opcode . "\n";
        $output .= ";;\t aa         = " . $this->aa . "\n";
        $output .= ";;\t tc         = " . $this->tc . "\n";
        $output .= ";;\t rd         = " . $this->rd . "\n";
        $output .= ";;\t ra         = " . $this->ra . "\n";
        $output .= ";;\t z          = " . $this->z . "\n";
        $output .= ";;\t ad         = " . $this->ad . "\n";
        $output .= ";;\t cd         = " . $this->cd . "\n";
        $output .= ";;\t rcode      = " . $this->rcode . "\n";
        $output .= ";;\t qdcount    = " . $this->qdcount . "\n";
        $output .= ";;\t ancount    = " . $this->ancount . "\n";
        $output .= ";;\t nscount    = " . $this->nscount . "\n";
        $output .= ";;\t arcount    = " . $this->arcount . "\n";

        return $output;
    }

    /**
     * constructs a Net_DNS2_Header from a Net_DNS2_Packet object
     *
     * @param Net_DNS2_Packet &$packet Object
     *
     * @return boolean
     * @throws Net_DNS2_Exception
     * @access public
     *
     */
    public function set(Net_DNS2_Packet &$packet)
    {
        //
        // the header must be at least 12 bytes long.
        //
        if ($packet->rdlength < Net_DNS2_Lookups::DNS_HEADER_SIZE) {

            throw new Net_DNS2_Exception(
                'invalid header data provided; to small',
                Net_DNS2_Lookups::E_HEADER_INVALID
            );
        }

        $offset = 0;

        //
        // parse the values
        //
        $this->id       = ord($packet->rdata[$offset]) << 8 | 
            ord($packet->rdata[++$offset]);

        ++$offset;
        $this->qr       = (ord($packet->rdata[$offset]) >> 7) & 0x1;
        $this->opcode   = (ord($packet->rdata[$offset]) >> 3) & 0xf;
        $this->aa       = (ord($packet->rdata[$offset]) >> 2) & 0x1;
        $this->tc       = (ord($packet->rdata[$offset]) >> 1) & 0x1;
        $this->rd       = ord($packet->rdata[$offset]) & 0x1;

        ++$offset;
        $this->ra       = (ord($packet->rdata[$offset]) >> 7) & 0x1;
        $this->z        = (ord($packet->rdata[$offset]) >> 6) & 0x1;
        $this->ad       = (ord($packet->rdata[$offset]) >> 5) & 0x1;
        $this->cd       = (ord($packet->rdata[$offset]) >> 4) & 0x1;
        $this->rcode    = ord($packet->rdata[$offset]) & 0xf;
            
        $this->qdcount  = ord($packet->rdata[++$offset]) << 8 | 
            ord($packet->rdata[++$offset]);
        $this->ancount  = ord($packet->rdata[++$offset]) << 8 | 
            ord($packet->rdata[++$offset]);
        $this->nscount  = ord($packet->rdata[++$offset]) << 8 | 
            ord($packet->rdata[++$offset]);
        $this->arcount  = ord($packet->rdata[++$offset]) << 8 | 
            ord($packet->rdata[++$offset]);

        //
        // increment the internal offset
        //
        $packet->offset += Net_DNS2_Lookups::DNS_HEADER_SIZE;

        return true;
    }

    /**
     * returns a binary packed DNS Header
     *
     * @param Net_DNS2_Packet &$packet Object
     *
     * @return    string
     * @access    public
     *
     */
    public function get(Net_DNS2_Packet &$packet)
    {
        $packet->offset += Net_DNS2_Lookups::DNS_HEADER_SIZE;

        return pack('n', $this->id) . 
            chr(
                ($this->qr << 7) | ($this->opcode << 3) | 
                ($this->aa << 2) | ($this->tc << 1) | ($this->rd)
            ) .
            chr(
                ($this->ra << 7) | ($this->ad << 5) | ($this->cd << 4) | $this->rcode
            ) .
            pack('n4', $this->qdcount, $this->ancount, $this->nscount, $this->arcount);
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

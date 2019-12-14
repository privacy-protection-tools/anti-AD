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
 * TSIG Resource Record - RFC 2845
 *
 *      0 1 2 3 4 5 6 7 0 1 2 3 4 5 6 7 0 1 2 3 4 5 6 7 0 1 2 3 4 5 6 7
 *     +-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+
 *     /                          algorithm                            /
 *     /                                                               /
 *     +-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+
 *     |                          time signed                          |
 *     |                               +-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+
 *     |                               |              fudge            |
 *     +-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+
 *     |            mac size           |                               /
 *     +-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+                               /
 *     /                              mac                              /
 *     +-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+
 *     |           original id         |              error            |
 *     +-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+
 *     |          other length         |                               /
 *     +-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+                               /
 *     /                          other data                           /
 *     +-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+
 *
 * @category Networking
 * @package  Net_DNS2
 * @author   Mike Pultz <mike@mikepultz.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link     http://pear.php.net/package/Net_DNS2
 * @see      Net_DNS2_RR
 *
 */
class Net_DNS2_RR_TSIG extends Net_DNS2_RR
{
    /*
     * TSIG Algorithm Identifiers
     */
    const HMAC_MD5      = 'hmac-md5.sig-alg.reg.int';   // RFC 2845, required
    const GSS_TSIG      = 'gss-tsig';                   // unsupported, optional
    const HMAC_SHA1     = 'hmac-sha1';                  // RFC 4635, required
    const HMAC_SHA224   = 'hmac-sha224';                // RFC 4635, optional
    const HMAC_SHA256   = 'hmac-sha256';                // RFC 4635, required
    const HMAC_SHA384   = 'hmac-sha384';                // RFC 4635, optional
    const HMAC_SHA512   = 'hmac-sha512';                // RFC 4635, optional

    /*
     * the map of hash values to names
     */
    public static $hash_algorithms = array(

        self::HMAC_MD5      => 'md5',
        self::HMAC_SHA1     => 'sha1',
        self::HMAC_SHA224   => 'sha224',
        self::HMAC_SHA256   => 'sha256',
        self::HMAC_SHA384   => 'sha384',
        self::HMAC_SHA512   => 'sha512'
    );

    /*
     * algorithm used; only supports HMAC-MD5
     */
    public $algorithm;

    /*
     * The time it was signed
     */
    public $time_signed;

    /*
     * fudge- allowed offset from the time signed
     */
    public $fudge;

    /*
     * size of the digest
     */
    public $mac_size;

    /*
     * the digest data
     */
    public $mac;

    /*
     * the original id of the request
     */
    public $original_id;

    /*
     * additional error code
     */
    public $error;

    /*
     * length of the "other" data, should only ever be 0 when there is
     * no error, or 6 when there is the error RCODE_BADTIME
     */
    public $other_length;

    /*
     * the other data; should only ever be a timestamp when there is the
     * error RCODE_BADTIME
     */
    public $other_data;

    /*
     * the key to use for signing - passed in, not included in the rdata
     */
    public $key;

    /**
     * method to return the rdata portion of the packet as a string
     *
     * @return  string
     * @access  protected
     *
     */
    protected function rrToString()
    {
        $out = $this->cleanString($this->algorithm) . '. ' . 
            $this->time_signed . ' ' . 
            $this->fudge . ' ' . $this->mac_size . ' ' .
            base64_encode($this->mac) . ' ' . $this->original_id . ' ' . 
            $this->error . ' '. $this->other_length;

        if ($this->other_length > 0) {

            $out .= ' ' . $this->other_data;
        }

        return $out;
    }

    /**
     * parses the rdata portion from a standard DNS config line
     *
     * @param array $rdata a string split line of values for the rdata
     *
     * @return boolean
     * @access protected
     *
     */
    protected function rrFromString(array $rdata)
    {
        //
        // the only value passed in is the key-
        //
        // this assumes it's passed in base64 encoded.
        //
        $this->key = preg_replace('/\s+/', '', array_shift($rdata));

        //
        // the rest of the data is set to default
        //
        $this->algorithm    = self::HMAC_MD5;
        $this->time_signed  = time();
        $this->fudge        = 300;
        $this->mac_size     = 0;
        $this->mac          = '';
        $this->original_id  = 0;
        $this->error        = 0;
        $this->other_length = 0;
        $this->other_data   = '';

        //
        // per RFC 2845 section 2.3
        //
        $this->class        = 'ANY';
        $this->ttl          = 0;

        return true;
    }

    /**
     * parses the rdata of the Net_DNS2_Packet object
     *
     * @param Net_DNS2_Packet &$packet a Net_DNS2_Packet packet to parse the RR from
     *
     * @return boolean
     * @access protected
     *
     */
    protected function rrSet(Net_DNS2_Packet &$packet)
    {
        if ($this->rdlength > 0) {

            //
            // expand the algorithm
            //
            $newoffset          = $packet->offset;
            $this->algorithm    = Net_DNS2_Packet::expand($packet, $newoffset);
            $offset             = $newoffset - $packet->offset;

            //
            // unpack time, fudge and mac_size
            //
            $x = unpack(
                '@' . $offset . '/ntime_high/Ntime_low/nfudge/nmac_size', 
                $this->rdata
            );

            $this->time_signed  = Net_DNS2::expandUint32($x['time_low']);
            $this->fudge        = $x['fudge'];
            $this->mac_size     = $x['mac_size'];

            $offset += 10;

            //
            // copy out the mac
            //
            if ($this->mac_size > 0) {
            
                $this->mac = substr($this->rdata, $offset, $this->mac_size);
                $offset += $this->mac_size;
            }

            //
            // unpack the original id, error, and other_length values
            //
            $x = unpack(
                '@' . $offset . '/noriginal_id/nerror/nother_length', 
                $this->rdata
            );
        
            $this->original_id  = $x['original_id'];
            $this->error        = $x['error'];
            $this->other_length = $x['other_length'];

            //
            // the only time there is actually any "other data", is when there's
            // a BADTIME error code.
            //
            // The other length should be 6, and the other data field includes the
            // servers current time - per RFC 2845 section 4.5.2
            //
            if ($this->error == Net_DNS2_Lookups::RCODE_BADTIME) {

                if ($this->other_length != 6) {

                    return false;
                }

                //
                // other data is a 48bit timestamp
                //
                $x = unpack(
                    'nhigh/nlow', 
                    substr($this->rdata, $offset + 6, $this->other_length)
                );
                $this->other_data = $x['low'];
            }

            return true;
        }

        return false;
    }

    /**
     * returns the rdata portion of the DNS packet
     *
     * @param Net_DNS2_Packet &$packet a Net_DNS2_Packet packet use for
     *                                 compressed names
     *
     * @return mixed                   either returns a binary packed
     *                                 string or null on failure
     * @access protected
     *
     */
    protected function rrGet(Net_DNS2_Packet &$packet)
    {
        if (strlen($this->key) > 0) {

            //
            // create a new packet for the signature-
            //
            $new_packet = new Net_DNS2_Packet_Request('example.com', 'SOA', 'IN');

            //
            // copy the packet data over
            //
            $new_packet->copy($packet);

            //
            // remove the TSIG object from the additional list
            //
            array_pop($new_packet->additional);
            $new_packet->header->arcount = count($new_packet->additional);

            //
            // copy out the data
            //
            $sig_data = $new_packet->get();

            //
            // add the name without compressing
            //
            $sig_data .= Net_DNS2_Packet::pack($this->name);

            //
            // add the class and TTL
            //
            $sig_data .= pack(
                'nN', Net_DNS2_Lookups::$classes_by_name[$this->class], $this->ttl
            );

            //
            // add the algorithm name without compression
            //
            $sig_data .= Net_DNS2_Packet::pack(strtolower($this->algorithm));

            //
            // add the rest of the values
            //
            $sig_data .= pack(
                'nNnnn', 0, $this->time_signed, $this->fudge, 
                $this->error, $this->other_length
            );
            if ($this->other_length > 0) {

                $sig_data .= pack('nN', 0, $this->other_data);
            }

            //
            // sign the data
            //
            $this->mac = $this->_signHMAC(
                $sig_data, base64_decode($this->key), $this->algorithm
            );
            $this->mac_size = strlen($this->mac);

            //
            // compress the algorithm
            //
            $data = Net_DNS2_Packet::pack(strtolower($this->algorithm));

            //
            // pack the time, fudge and mac size
            //
            $data .= pack(
                'nNnn', 0, $this->time_signed, $this->fudge, $this->mac_size
            );
            $data .= $this->mac;

            //
            // check the error and other_length
            //
            if ($this->error == Net_DNS2_Lookups::RCODE_BADTIME) {

                $this->other_length = strlen($this->other_data);
                if ($this->other_length != 6) {

                    return null;
                }
            } else {

                $this->other_length = 0;
                $this->other_data = '';
            }

            //
            // pack the id, error and other_length
            //
            $data .= pack(
                'nnn', $packet->header->id, $this->error, $this->other_length
            );
            if ($this->other_length > 0) {

                $data .= pack('nN', 0, $this->other_data);
            }

            $packet->offset += strlen($data);

            return $data;
        }

        return null;
    }

    /**
     * signs the given data with the given key, and returns the result
     *
     * @param string $data      the data to sign
     * @param string $key       key to use for signing
     * @param string $algorithm the algorithm to use; defaults to MD5
     *
     * @return string the signed digest
     * @throws Net_DNS2_Exception
     * @access private
     *
     */
    private function _signHMAC($data, $key = null, $algorithm = self::HMAC_MD5)
    {
        //
        // use the hash extension; this is included by default in >= 5.1.2 which
        // is our dependent version anyway- so it's easy to switch to it.
        //
        if (extension_loaded('hash')) {

            if (!isset(self::$hash_algorithms[$algorithm])) {

                throw new Net_DNS2_Exception(
                    'invalid or unsupported algorithm',
                    Net_DNS2_Lookups::E_PARSE_ERROR
                );
            }

            return hash_hmac(self::$hash_algorithms[$algorithm], $data, $key, true);
        }

        //
        // if the hash extension isn't loaded, and they selected something other
        // than MD5, throw an exception
        //
        if ($algorithm != self::HMAC_MD5) {

            throw new Net_DNS2_Exception(
                'only HMAC-MD5 supported. please install the php-extension ' .
                '"hash" in order to use the sha-family',
                Net_DNS2_Lookups::E_PARSE_ERROR
            );
        }

        //
        // otherwise, do it ourselves
        //
        if (is_null($key)) {

            return pack('H*', md5($data));
        }

        $key = str_pad($key, 64, chr(0x00));
        if (strlen($key) > 64) {
    
            $key = pack('H*', md5($key));
        }

        $k_ipad = $key ^ str_repeat(chr(0x36), 64);
        $k_opad = $key ^ str_repeat(chr(0x5c), 64);

        return $this->_signHMAC(
            $k_opad . pack('H*', md5($k_ipad . $data)), null, $algorithm
        );
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

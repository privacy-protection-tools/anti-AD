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
 * SSHFP Resource Record - RFC4255 section 3.1
 *
 *       0 1 2 3 4 5 6 7 8 9 0 1 2 3 4 5 6 7 8 9 0 1 2 3 4 5 6 7 8 9 0 1
 *      +-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+
 *      |   algorithm   |    fp type    |                               /
 *      +-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+                               /
 *      /                                                               /
 *      /                          fingerprint                          /
 *      /                                                               /
 *      +-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+
 * 
 * @category Networking
 * @package  Net_DNS2
 * @author   Mike Pultz <mike@mikepultz.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link     http://pear.php.net/package/Net_DNS2
 * @see      Net_DNS2_RR
 *
 */
class Net_DNS2_RR_SSHFP extends Net_DNS2_RR
{
    /*
     * the algorithm used
     */
    public $algorithm;

    /*
     * The finger print type
     */
    public $fp_type;

    /*
     * the finger print data
     */
    public $fingerprint;

    /*
     * Algorithms
     */
    const SSHFP_ALGORITHM_RES       = 0;
    const SSHFP_ALGORITHM_RSA       = 1;
    const SSHFP_ALGORITHM_DSS       = 2;
    const SSHFP_ALGORITHM_ECDSA     = 3;
    const SSHFP_ALGORITHM_ED25519   = 4;

    /*
     * Fingerprint Types
     */
    const SSHFP_FPTYPE_RES      = 0;
    const SSHFP_FPTYPE_SHA1     = 1;
    const SSHFP_FPTYPE_SHA256   = 2;


    /**
     * method to return the rdata portion of the packet as a string
     *
     * @return  string
     * @access  protected
     *
     */
    protected function rrToString()
    {
        return $this->algorithm . ' ' . $this->fp_type . ' ' . $this->fingerprint;
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
        // "The use of mnemonics instead of numbers is not allowed."
        // 
        // RFC4255 section 3.2
        //
        $algorithm      = array_shift($rdata);
        $fp_type        = array_shift($rdata);
        $fingerprint    = strtolower(implode('', $rdata));

        //
        // There are only two algorithm's defined 
        //
        if ( ($algorithm != self::SSHFP_ALGORITHM_RSA) 
            && ($algorithm != self::SSHFP_ALGORITHM_DSS) 
            && ($algorithm != self::SSHFP_ALGORITHM_ECDSA) 
            && ($algorithm != self::SSHFP_ALGORITHM_ED25519)
        ) {
            return false;
        }

        //
        // there are only two fingerprints defined
        //
        if ( ($fp_type != self::SSHFP_FPTYPE_SHA1)
            && ($fp_type != self::SSHFP_FPTYPE_SHA256) 
        ) {
            return false;
        }

        $this->algorithm    = $algorithm;
        $this->fp_type      = $fp_type;
        $this->fingerprint  = $fingerprint;

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
            // unpack the algorithm and finger print type
            //
            $x = unpack('Calgorithm/Cfp_type', $this->rdata);

            $this->algorithm    = $x['algorithm'];
            $this->fp_type      = $x['fp_type'];

            //
            // There are only three algorithm's defined 
            //
            if ( ($this->algorithm != self::SSHFP_ALGORITHM_RSA) 
                && ($this->algorithm != self::SSHFP_ALGORITHM_DSS)
                && ($this->algorithm != self::SSHFP_ALGORITHM_ECDSA)
                && ($this->algorithm != self::SSHFP_ALGORITHM_ED25519)
            ) {
                return false;
            }

            //
            // there are only two fingerprints defined
            //
            if ( ($this->fp_type != self::SSHFP_FPTYPE_SHA1)
                && ($this->fp_type != self::SSHFP_FPTYPE_SHA256)
            ) {
                return false;
            }
            
            //
            // parse the finger print; this assumes SHA-1
            //
            $fp = unpack('H*a', substr($this->rdata, 2));
            $this->fingerprint = strtolower($fp['a']);

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
        if (strlen($this->fingerprint) > 0) {

            $data = pack(
                'CCH*', $this->algorithm, $this->fp_type, $this->fingerprint
            );

            $packet->offset += strlen($data);

            return $data;
        }

        return null;
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

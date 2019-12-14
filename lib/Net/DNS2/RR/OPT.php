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
 * @since     File available since Release 1.0.0
 *
 */

/**
 * OPT Resource Record - RFC2929 section 3.1
 *
 *    +---+---+---+---+---+---+---+---+---+---+---+---+---+---+---+---+
 *    |                          OPTION-CODE                          |
 *    +---+---+---+---+---+---+---+---+---+---+---+---+---+---+---+---+
 *    |                         OPTION-LENGTH                         |
 *    +---+---+---+---+---+---+---+---+---+---+---+---+---+---+---+---+
 *    |                                                               |
 *    /                          OPTION-DATA                          /
 *    /                                                               /
 *    +---+---+---+---+---+---+---+---+---+---+---+---+---+---+---+---+
 *
 * @category Networking
 * @package  Net_DNS2
 * @author   Mike Pultz <mike@mikepultz.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link     http://pear.php.net/package/Net_DNS2
 * @see      Net_DNS2_RR
 *
 */
class Net_DNS2_RR_OPT extends Net_DNS2_RR
{
    /*
     * option code - assigned by IANA
     */
    public $option_code;

    /*
     * the length of the option data
     */
    public $option_length;

    /*
     * the option data
     */
    public $option_data;

    /*
     * the extended response code stored in the TTL
     */
    public $extended_rcode;

    /*
     * the implementation level
     */
    public $version;

    /*
     * the DO bit used for DNSSEC - RFC3225
     */
    public $do;

    /*
     * the extended flags
     */
    public $z;

    /**
     * Constructor - builds a new Net_DNS2_RR_OPT object; normally you wouldn't call
     * this directly, but OPT RR's are a little different
     *
     * @param Net_DNS2_Packet &$packet a Net_DNS2_Packet packet or null to create
     *                                 an empty object
     * @param array           $rr      an array with RR parse values or null to
     *                                 create an empty object
     *
     * @throws Net_DNS2_Exception
     * @access public
     *
     */
    public function __construct(Net_DNS2_Packet &$packet = null, array $rr = null)
    {
        //
        // this is for when we're manually building an OPT RR object; we aren't
        // passing in binary data to parse, we just want a clean/empty object.
        //
        $this->type             = 'OPT';
        $this->rdlength         = 0;

        $this->option_length    = 0;
        $this->extended_rcode   = 0;
        $this->version          = 0;
        $this->do               = 0;
        $this->z                = 0;

        //
        // everthing else gets passed through to the parent.
        //
        if ( (!is_null($packet)) && (!is_null($rr)) ) {

            parent::__construct($packet, $rr);
        }
    }

    /**
     * method to return the rdata portion of the packet as a string. There is no
     * defintion for returning an OPT RR by string- this is just here to validate
     * the binary parsing / building routines.
     *
     * @return  string
     * @access  protected
     *
     */
    protected function rrToString()
    {
        return $this->option_code . ' ' . $this->option_data;
    }

    /**
     * parses the rdata portion from a standard DNS config line. There is no 
     * definition for parsing a OPT RR by string- this is just here to validate
     * the binary parsing / building routines.
     *
     * @param array $rdata a string split line of values for the rdata
     *
     * @return boolean
     * @access protected
     *
     */
    protected function rrFromString(array $rdata)
    {
        $this->option_code      = array_shift($rdata);
        $this->option_data      = array_shift($rdata);
        $this->option_length    = strlen($this->option_data);

        $x = unpack('Cextended/Cversion/Cdo/Cz', pack('N', $this->ttl));

        $this->extended_rcode   = $x['extended'];
        $this->version          = $x['version'];
        $this->do               = ($x['do'] >> 7);
        $this->z                = $x['z'];

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
        //
        // parse out the TTL value
        //
        $x = unpack('Cextended/Cversion/Cdo/Cz', pack('N', $this->ttl));

        $this->extended_rcode   = $x['extended'];
        $this->version          = $x['version'];
        $this->do               = ($x['do'] >> 7);
        $this->z                = $x['z'];

        //
        // parse the data, if there is any
        //
        if ($this->rdlength > 0) {

            //
            // unpack the code and length
            //
            $x = unpack('noption_code/noption_length', $this->rdata);

            $this->option_code      = $x['option_code'];
            $this->option_length    = $x['option_length'];

            //
            // copy out the data based on the length
            //
            $this->option_data      = substr($this->rdata, 4);
        }

        return true;
    }

    /**
     * pre-builds the TTL value for this record; we needed to separate this out
     * from the rrGet() function, as the logic in the Net_DNS2_RR packs the TTL
     * value before it builds the rdata value.
     *
     * @return void
     * @access protected
     *
     */
    protected function preBuild()
    {
        //
        // build the TTL value based on the local values
        //
        $ttl = unpack(
            'N', 
            pack('CCCC', $this->extended_rcode, $this->version, ($this->do << 7), 0)
        );

        $this->ttl = $ttl[1];

        return;
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
        //
        // if there is an option code, then pack that data too
        //
        if ($this->option_code) {

            $data = pack('nn', $this->option_code, $this->option_length) . 
                $this->option_data;

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

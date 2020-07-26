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
 * APL Resource Record - RFC3123
 *
 *     +---+---+---+---+---+---+---+---+---+---+---+---+---+---+---+---+
 *     |                          ADDRESSFAMILY                        |
 *     +---+---+---+---+---+---+---+---+---+---+---+---+---+---+---+---+
 *     |             PREFIX            | N |         AFDLENGTH         |
 *     +---+---+---+---+---+---+---+---+---+---+---+---+---+---+---+---+
 *     /                            AFDPART                            /
 *     |                                                               |
 *     +---+---+---+---+---+---+---+---+---+---+---+---+---+---+---+---+
 * 
 * @category Networking
 * @package  Net_DNS2
 * @author   Mike Pultz <mike@mikepultz.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link     http://pear.php.net/package/Net_DNS2
 * @see      Net_DNS2_RR
 *
 */
class Net_DNS2_RR_APL extends Net_DNS2_RR
{
    /*
     * a list of all the address prefix list items
     */
    public $apl_items = array();

    /**
     * method to return the rdata portion of the packet as a string
     *
     * @return  string
     * @access  protected
     *
     */
    protected function rrToString()
    {
        $out = '';

        foreach ($this->apl_items as $item) {

            if ($item['n'] == 1) {

                $out .= '!';
            }

            $out .= $item['address_family'] . ':' . 
                $item['afd_part'] . '/' . $item['prefix'] . ' ';
        }

        return trim($out);
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
        foreach ($rdata as $item) {

            if (preg_match('/^(!?)([1|2])\:([^\/]*)\/([0-9]{1,3})$/', $item, $m)) {

                $i = array(

                    'address_family'    => $m[2],
                    'prefix'            => $m[4],
                    'n'                 => ($m[1] == '!') ? 1 : 0,
                    'afd_part'          => strtolower($m[3])
                );

                $address = $this->_trimZeros(
                    $i['address_family'], $i['afd_part']
                );
                    
                $i['afd_length'] = count(explode('.', $address));

                $this->apl_items[] = $i;
            }
        }

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

            $offset = 0;

            while ($offset < $this->rdlength) {

                //
                // unpack the family, prefix, negate and length values
                //   
                $x = unpack(
                    'naddress_family/Cprefix/Cextra', substr($this->rdata, $offset)
                );

                $item = array(
            
                    'address_family'    => $x['address_family'],
                    'prefix'            => $x['prefix'],
                    'n'                 => ($x['extra'] >> 7) & 0x1,
                    'afd_length'        => $x['extra'] & 0xf
                );

                switch($item['address_family']) {

                case 1:
                    $r = unpack(
                        'C*', substr($this->rdata, $offset + 4, $item['afd_length'])
                    );
                    if (count($r) < 4) {

                        for ($c=count($r)+1; $c<4+1; $c++) {

                            $r[$c] = 0;
                        }
                    }

                    $item['afd_part'] = implode('.', $r);

                    break;
                case 2:
                    $r = unpack(
                        'C*', substr($this->rdata, $offset + 4, $item['afd_length'])
                    );
                    if (count($r) < 8) {

                        for ($c=count($r)+1; $c<8+1; $c++) {

                            $r[$c] = 0;
                        }
                    }

                    $item['afd_part'] = sprintf(
                        '%x:%x:%x:%x:%x:%x:%x:%x', 
                        $r[1], $r[2], $r[3], $r[4], $r[5], $r[6], $r[7], $r[8]
                    );

                    break;
                default:
                    return false;
                }

                $this->apl_items[] = $item;

                $offset += 4 + $item['afd_length'];
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
        if (count($this->apl_items) > 0) {

            $data = '';

            foreach ($this->apl_items as $item) {

                //
                // pack the address_family and prefix values
                //
                $data .= pack(
                    'nCC', 
                    $item['address_family'], 
                    $item['prefix'],
                    ($item['n'] << 7) | $item['afd_length']
                );

                switch($item['address_family']) {
                case 1:
                    $address = explode(
                        '.', 
                        $this->_trimZeros($item['address_family'], $item['afd_part'])
                    );

                    foreach ($address as $b) {
                        $data .= chr($b);
                    }
                    break;
                case 2:
                    $address = explode(
                        ':', 
                        $this->_trimZeros($item['address_family'], $item['afd_part'])
                    );

                    foreach ($address as $b) {
                        $data .= pack('H', $b);
                    }
                    break;
                default:
                    return null;
                }
            }

            $packet->offset += strlen($data);

            return $data;
        }

        return null;
    }

    /**
     * returns an IP address with the right-hand zero's trimmed
     *
     * @param integer $family  the IP address family from the rdata
     * @param string  $address the IP address
     *
     * @return string the trimmed IP addresss.
     *
     * @access private
     *
     */
    private function _trimZeros($family, $address)
    {
        $a = array();

        switch($family) {
        case 1:
            $a = array_reverse(explode('.', $address));
            break;
        case 2:
            $a = array_reverse(explode(':', $address));
            break;
        default:
            return '';
        }

        foreach ($a as $value) {

            if ($value === '0') {

                array_shift($a);
            }
        }

        $out = '';

        switch($family) {
        case 1:
            $out = implode('.', array_reverse($a));
            break;
        case 2:
            $out = implode(':', array_reverse($a));
            break;
        default:
            return '';
        }

        return $out;
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

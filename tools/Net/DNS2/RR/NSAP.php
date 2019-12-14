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
 * NSAP Resource Record - RFC1706
 *
 *             |--------------|
 *             | <-- IDP -->  |
 *             |--------------|-------------------------------------|
 *             | AFI |  IDI   |            <-- DSP -->              |
 *             |-----|--------|-------------------------------------|
 *             | 47  |  0005  | DFI | AA |Rsvd | RD |Area | ID |Sel |
 *             |-----|--------|-----|----|-----|----|-----|----|----|
 *      octets |  1  |   2    |  1  | 3  |  2  | 2  |  2  | 6  | 1  |
 *             |-----|--------|-----|----|-----|----|-----|----|----|
 * 
 * @category Networking
 * @package  Net_DNS2
 * @author   Mike Pultz <mike@mikepultz.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link     http://pear.php.net/package/Net_DNS2
 * @see      Net_DNS2_RR
 *
 */
class Net_DNS2_RR_NSAP extends Net_DNS2_RR
{
    public $afi;
    public $idi;
    public $dfi;
    public $aa;
    public $rsvd;
    public $rd;
    public $area;
    public $id;
    public $sel;

    /**
     * method to return the rdata portion of the packet as a string
     *
     * @return  string
     * @access  protected
     *
     */
    protected function rrToString()
    {
        return $this->cleanString($this->afi) . '.' . 
            $this->cleanString($this->idi) . '.' . 
            $this->cleanString($this->dfi) . '.' . 
            $this->cleanString($this->aa) . '.' . 
            $this->cleanString($this->rsvd) . '.' . 
            $this->cleanString($this->rd) . '.' . 
            $this->cleanString($this->area) . '.' . 
            $this->cleanString($this->id) . '.' . 
            $this->sel;
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
        $data = strtolower(trim(array_shift($rdata)));

        //
        // there is no real standard for format, so we can't rely on the fact that
        // the value will come in with periods separating the values- so strip 
        // them out if they're included, and parse without them.
        //    
        $data = str_replace(array('.', '0x'), '', $data);

        //
        // unpack it as ascii characters
        //
        $x = unpack('A2afi/A4idi/A2dfi/A6aa/A4rsvd/A4rd/A4area/A12id/A2sel', $data);
        
        //
        // make sure the afi value is 47
        //
        if ($x['afi'] == '47') {

            $this->afi  = '0x' . $x['afi'];
            $this->idi  = $x['idi'];
            $this->dfi  = $x['dfi'];
            $this->aa   = $x['aa'];
            $this->rsvd = $x['rsvd'];
            $this->rd   = $x['rd'];
            $this->area = $x['area'];
            $this->id   = $x['id'];
            $this->sel  = $x['sel'];

            return true;
        }

        return false;
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
        if ($this->rdlength == 20) {

            //
            // get the AFI value
            //
            $this->afi = dechex(ord($this->rdata[0]));

            //
            // we only support AFI 47- there arent' any others defined.
            //
            if ($this->afi == '47') {

                //
                // unpack the rest of the values
                //
                $x = unpack(
                    'Cafi/nidi/Cdfi/C3aa/nrsvd/nrd/narea/Nidh/nidl/Csel', 
                    $this->rdata
                );

                $this->afi  = sprintf('0x%02x', $x['afi']);
                $this->idi  = sprintf('%04x', $x['idi']);
                $this->dfi  = sprintf('%02x', $x['dfi']);
                $this->aa   = sprintf(
                    '%06x', $x['aa1'] << 16 | $x['aa2'] << 8 | $x['aa3']
                );
                $this->rsvd = sprintf('%04x', $x['rsvd']);
                $this->rd   = sprintf('%04x', $x['rd']);
                $this->area = sprintf('%04x', $x['area']);
                $this->id   = sprintf('%08x', $x['idh']) . 
                    sprintf('%04x', $x['idl']);
                $this->sel  = sprintf('%02x', $x['sel']);

                return true;
            }
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
        if ($this->afi == '0x47') {

            //
            // build the aa field
            //
            $aa = unpack('A2x/A2y/A2z', $this->aa);

            //
            // build the id field
            //
            $id = unpack('A8a/A4b', $this->id);

            //
            $data = pack(
                'CnCCCCnnnNnC', 
                hexdec($this->afi), 
                hexdec($this->idi),
                hexdec($this->dfi),
                hexdec($aa['x']),
                hexdec($aa['y']),
                hexdec($aa['z']),
                hexdec($this->rsvd),
                hexdec($this->rd),
                hexdec($this->area),
                hexdec($id['a']),
                hexdec($id['b']),
                hexdec($this->sel)
            );

            if (strlen($data) == 20) {
                
                $packet->offset += 20;
                return $data;
            }
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

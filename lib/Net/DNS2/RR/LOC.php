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
 * LOC Resource Record - RFC1876 section 2
 *
 *      +--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+
 *      |        VERSION        |         SIZE          |
 *      +--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+
 *      |       HORIZ PRE       |       VERT PRE        |
 *      +--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+
 *      |                   LATITUDE                    |
 *      |                                               |
 *      +--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+
 *      |                   LONGITUDE                   |
 *      |                                               |
 *      +--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+
 *      |                   ALTITUDE                    |
 *      |                                               |
 *      +--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+
 *
 * @category Networking
 * @package  Net_DNS2
 * @author   Mike Pultz <mike@mikepultz.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link     http://pear.php.net/package/Net_DNS2
 * @see      Net_DNS2_RR
 *
 */
class Net_DNS2_RR_LOC extends Net_DNS2_RR
{
    /*
     * the LOC version- should only ever be 0
     */
    public $version;

    /*
     * The diameter of a sphere enclosing the described entity
     */
    public $size;

    /*
     * The horizontal precision of the data
     */
    public $horiz_pre;

    /*
     * The vertical precision of the data
     */
    public $vert_pre;

    /*
     * The latitude - stored in decimal degrees
     */
    public $latitude;

    /* 
     * The longitude - stored in decimal degrees
     */
    public $longitude;

    /*
     * The altitude - stored in decimal
     */
    public $altitude;

    /*
     * used for quick power-of-ten lookups
     */
    private $_powerOfTen = array(1, 10, 100, 1000, 10000, 100000, 
                                 1000000,10000000,100000000,1000000000);

    /*
     * some conversion values
     */
    const CONV_SEC          = 1000;
    const CONV_MIN          = 60000;
    const CONV_DEG          = 3600000;

    const REFERENCE_ALT     = 10000000;
    const REFERENCE_LATLON  = 2147483648;

    /**
     * method to return the rdata portion of the packet as a string
     *
     * @return  string
     * @access  protected
     *
     */
    protected function rrToString()
    {
        if ($this->version == 0) {

            return $this->_d2Dms($this->latitude, 'LAT') . ' ' . 
                $this->_d2Dms($this->longitude, 'LNG') . ' ' . 
                sprintf('%.2fm', $this->altitude) . ' ' .
                sprintf('%.2fm', $this->size) . ' ' .
                sprintf('%.2fm', $this->horiz_pre) . ' ' .
                sprintf('%.2fm', $this->vert_pre);
        }
        
        return '';
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
        // format as defined by RFC1876 section 3
        //
        // d1 [m1 [s1]] {"N"|"S"} d2 [m2 [s2]] {"E"|"W"} alt["m"] 
        //      [siz["m"] [hp["m"] [vp["m"]]]]
        //
        $res = preg_match(
            '/^(\d+) \s+((\d+) \s+)?(([\d.]+) \s+)?(N|S) \s+(\d+) ' .
            '\s+((\d+) \s+)?(([\d.]+) \s+)?(E|W) \s+(-?[\d.]+) m?(\s+ ' .
            '([\d.]+) m?)?(\s+ ([\d.]+) m?)?(\s+ ([\d.]+) m?)?/ix', 
            implode(' ', $rdata), $x
        );

        if ($res) {

            //
            // latitude
            //
            $latdeg     = $x[1];
            $latmin     = (isset($x[3])) ? $x[3] : 0;
            $latsec     = (isset($x[5])) ? $x[5] : 0;
            $lathem     = strtoupper($x[6]);

            $this->latitude = $this->_dms2d($latdeg, $latmin, $latsec, $lathem);

            //
            // longitude
            //
            $londeg     = $x[7];
            $lonmin     = (isset($x[9])) ? $x[9] : 0;
            $lonsec     = (isset($x[11])) ? $x[11] : 0;
            $lonhem     = strtoupper($x[12]);

            $this->longitude = $this->_dms2d($londeg, $lonmin, $lonsec, $lonhem);

            //
            // the rest of teh values
            //
            $version            = 0;

            $this->size         = (isset($x[15])) ? $x[15] : 1;
            $this->horiz_pre    = ((isset($x[17])) ? $x[17] : 10000);
            $this->vert_pre     = ((isset($x[19])) ? $x[19] : 10);
            $this->altitude     = $x[13];

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
        if ($this->rdlength > 0) {

            //
            // unpack all the values
            //
            $x = unpack(
                'Cver/Csize/Choriz_pre/Cvert_pre/Nlatitude/Nlongitude/Naltitude', 
                $this->rdata
            );

            //
            // version must be 0 per RFC 1876 section 2
            //
            $this->version = $x['ver'];
            if ($this->version == 0) {

                $this->size         = $this->_precsizeNtoA($x['size']);
                $this->horiz_pre    = $this->_precsizeNtoA($x['horiz_pre']);
                $this->vert_pre     = $this->_precsizeNtoA($x['vert_pre']);

                //
                // convert the latitude and longitude to degress in decimal
                //
                if ($x['latitude'] < 0) {

                    $this->latitude = ($x['latitude'] + 
                        self::REFERENCE_LATLON) / self::CONV_DEG;
                } else {

                    $this->latitude = ($x['latitude'] - 
                        self::REFERENCE_LATLON) / self::CONV_DEG;
                }

                if ($x['longitude'] < 0) {
 
                    $this->longitude = ($x['longitude'] + 
                        self::REFERENCE_LATLON) / self::CONV_DEG;
                } else {

                    $this->longitude = ($x['longitude'] - 
                        self::REFERENCE_LATLON) / self::CONV_DEG;
                }

                //
                // convert down the altitude
                //
                $this->altitude = ($x['altitude'] - self::REFERENCE_ALT) / 100;

                return true;

            } else {

                return false;
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
        if ($this->version == 0) {

            $lat = 0;
            $lng = 0;

            if ($this->latitude < 0) {

                $lat = ($this->latitude * self::CONV_DEG) - self::REFERENCE_LATLON;
            } else {

                $lat = ($this->latitude * self::CONV_DEG) + self::REFERENCE_LATLON;
            }

            if ($this->longitude < 0) {

                $lng = ($this->longitude * self::CONV_DEG) - self::REFERENCE_LATLON;
            } else {

                $lng = ($this->longitude * self::CONV_DEG) + self::REFERENCE_LATLON;
            }

            $packet->offset += 16;

            return pack(
                'CCCCNNN', 
                $this->version,
                $this->_precsizeAtoN($this->size),
                $this->_precsizeAtoN($this->horiz_pre),
                $this->_precsizeAtoN($this->vert_pre),
                $lat, $lng,
                ($this->altitude * 100) + self::REFERENCE_ALT
            );
        }

        return null;
    }

    /**
     * takes an XeY precision/size value, returns a string representation.
     * shamlessly stolen from RFC1876 Appendix A
     *
     * @param integer $prec the value to convert
     *
     * @return string
     * @access private
     *
     */
    private function _precsizeNtoA($prec)
    {
        $mantissa = (($prec >> 4) & 0x0f) % 10;
        $exponent = (($prec >> 0) & 0x0f) % 10;

        return $mantissa * $this->_powerOfTen[$exponent];
    }

    /**
     * converts ascii size/precision X * 10**Y(cm) to 0xXY.
     * shamlessly stolen from RFC1876 Appendix A
     *
     * @param string $prec the value to convert
     *
     * @return integer
     * @access private
     *
     */
    private function _precsizeAtoN($prec)
    {
        $exponent = 0;
        while ($prec >= 10) {

            $prec /= 10;
            ++$exponent;
        }

        return ($prec << 4) | ($exponent & 0x0f);
    }

    /**
     * convert lat/lng in deg/min/sec/hem to decimal value
     *
     * @param integer $deg the degree value
     * @param integer $min the minutes value
     * @param integer $sec the seconds value
     * @param string  $hem the hemisphere (N/E/S/W)
     *
     * @return float the decinmal value
     * @access private
     *
     */
    private function _dms2d($deg, $min, $sec, $hem)
    {
        $deg = $deg - 0;
        $min = $min - 0;

        $sign = ($hem == 'W' || $hem == 'S') ? -1 : 1;
        return ((($sec/60+$min)/60)+$deg) * $sign;
    }

    /**
     * convert lat/lng in decimal to deg/min/sec/hem
     *
     * @param float  $data   the decimal value
     * @param string $latlng either LAT or LNG so we can determine the HEM value
     *
     * @return string
     * @access private
     *
     */
    private function _d2Dms($data, $latlng)
    {
        $deg = 0;
        $min = 0;
        $sec = 0;
        $msec = 0;
        $hem = '';

        if ($latlng == 'LAT') {
            $hem = ($data > 0) ? 'N' : 'S';
        } else {
            $hem = ($data > 0) ? 'E' : 'W';
        }

        $data = abs($data);

        $deg = (int)$data;
        $min = (int)(($data - $deg) * 60);
        $sec = (int)(((($data - $deg) * 60) - $min) * 60);
        $msec = round((((((($data - $deg) * 60) - $min) * 60) - $sec) * 1000));

        return sprintf('%d %02d %02d.%03d %s', $deg, $min, $sec, round($msec), $hem);
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

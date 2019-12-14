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
 */

/**
 * Exception handler used by Net_DNS2
 *
 * @category Networking
 * @package  Net_DNS2
 * @author   Mike Pultz <mike@mikepultz.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link     http://pear.php.net/package/Net_DNS2
 * 
 */
class Net_DNS2_Exception extends Exception
{
    private $_request;
    private $_response;

    /**
     * Constructor - overload the constructor so we can pass in the request
     *               and response object (when it's available)
     *
     * @param string $message  the exception message
     * @param int    $code     the exception code
     * @param object $previous the previous Exception object
     * @param object $request  the Net_DNS2_Packet_Request object for this request
     * @param object $response the Net_DNS2_Packet_Response object for this request
     *
     * @access public
     *
     */
    public function __construct(
        $message = '', 
        $code = 0, 
        $previous = null, 
        Net_DNS2_Packet_Request $request = null,
        Net_DNS2_Packet_Response $response = null
    ) {
        //
        // store the request/response objects (if passed)
        //
        $this->_request = $request;
        $this->_response = $response;

        //
        // call the parent constructor
        //
        // the "previous" argument was added in PHP 5.3.0
        //
        //      https://code.google.com/p/netdns2/issues/detail?id=25
        //
        if (version_compare(PHP_VERSION, '5.3.0', '>=') == true) {

            parent::__construct($message, $code, $previous);
        } else {

            parent::__construct($message, $code);
        }
    }

    /**
     * returns the Net_DNS2_Packet_Request object (if available)
     *
     * @return Net_DNS2_Packet_Request object
     * @access public
     * @since  function available since release 1.3.1
     *
     */
    public function getRequest()
    {
        return $this->_request;
    }

    /**
     * returns the Net_DNS2_Packet_Response object (if available)
     *
     * @return Net_DNS2_Packet_Response object
     * @access public
     * @since  function available since release 1.3.1
     *
     */
    public function getResponse()
    {
        return $this->_response;
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

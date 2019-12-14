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

/*
 * check to see if the socket defines exist; if they don't, then define them
 */
if (defined('SOCK_STREAM') == false) {
    define('SOCK_STREAM', 1);
}
if (defined('SOCK_DGRAM') == false) {
    define('SOCK_DGRAM', 2);
}

/**
 * This is the abstract base class for the two sockets classes; this simply
 * provides the class definition for the two sockets classes.
 *
 * @category Networking
 * @package  Net_DNS2
 * @author   Mike Pultz <mike@mikepultz.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link     http://pear.php.net/package/Net_DNS2
 * @see      Net_DNS2_Socket_Sockets, Net_DNS2_Socket_Streams
 *
 */
abstract class Net_DNS2_Socket
{
    protected $sock;
    protected $type;
    protected $host;
    protected $port;
    protected $timeout;

    protected $local_host;
    protected $local_port;

    public $last_error;

    /*
     * type of sockets
     */
    const SOCK_STREAM   = SOCK_STREAM;
    const SOCK_DGRAM    = SOCK_DGRAM;

    /**   
     * constructor - set the port details
     *
     * @param integer $type    the socket type
     * @param string  $host    the IP address of the DNS server to connect to
     * @param integer $port    the port of the DNS server to connect to
     * @param integer $timeout the timeout value to use for socket functions
     *
     * @access public
     *       
     */
    public function __construct($type, $host, $port, $timeout)
    {
        $this->type     = $type;
        $this->host     = $host;
        $this->port     = $port;
        $this->timeout  = $timeout;
    }

    /**
     * destructor
     *
     * @access public
     */
    public function __destruct()
    {
        $this->close();
    }

    /**   
     * sets the local address/port for the socket to bind to
     *
     * @param string $address the local IP address to bind to
     * @param mixed  $port    the local port to bind to, or 0 to let the socket
     *                        function select a port
     *
     * @return boolean
     * @access public
     *       
     */
    public function bindAddress($address, $port = 0)
    {
        $this->local_host = $address;
        $this->local_port = $port;

        return true;
    }

    /**
     * opens a socket connection to the DNS server
     *     
     * @return boolean
     * @access public
     *
     */
    abstract public function open();

    /**
     * closes a socket connection to the DNS server  
     *
     * @return boolean
     * @access public
     *     
     */
    abstract public function close();

    /**
     * writes the given string to the DNS server socket
     *
     * @param string $data a binary packed DNS packet
     *   
     * @return boolean
     * @access public
     *
     */
    abstract public function write($data);

    /**   
     * reads a response from a DNS server
     *
     * @param integer &$size    the size of the DNS packet read is passed back
     * @param integer $max_size the max data size returned.
     *
     * @return mixed         returns the data on success and false on error
     * @access public
     *       
     */
    abstract public function read(&$size, $max_size);
}

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */
?>

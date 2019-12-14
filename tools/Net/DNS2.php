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
 * register the auto-load function
 *
 */
spl_autoload_register('Net_DNS2::autoload');

/**
 * This is the base class for the Net_DNS2_Resolver and Net_DNS2_Updater
 * classes.
 *
 * @category Networking
 * @package  Net_DNS2
 * @author   Mike Pultz <mike@mikepultz.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link     http://pear.php.net/package/Net_DNS2
 * @see      Net_DNS2_Resolver, Net_DNS2_Updater
 *
 */
class Net_DNS2
{
    /*
     * the current version of this library
     */
    const VERSION = '1.4.4';

    /*
     * the default path to a resolv.conf file
     */
    const RESOLV_CONF = '/etc/resolv.conf';

    /*
     * override options from the resolv.conf file
     *
     * if this is set, then certain values from the resolv.conf file will override
     * local settings. This is disabled by default to remain backwards compatible.
     *
     */
    public $use_resolv_options = false;

    /*
     * use TCP only (true/false)
     */
    public $use_tcp = false;

    /*
     * DNS Port to use (53)
     */
    public $dns_port = 53;

    /*
     * the ip/port for use as a local socket
     */
    public $local_host = '';
    public $local_port = 0;

    /*
     * timeout value for socket connections
     */
    public $timeout = 5;

    /*
     * randomize the name servers list
     */
    public $ns_random = false;

    /*
     * default domains
     */
    public $domain = '';

    /*
     * domain search list - not actually used right now
     */
    public $search_list = array();

    /*
     * enable cache; either "shared", "file" or "none"
     */
    public $cache_type = 'none';

    /*
     * file name to use for shared memory segment or file cache
     */
    public $cache_file = '/tmp/net_dns2.cache';

    /*
     * the max size of the cache file (in bytes)
     */
    public $cache_size = 50000;

    /*
     * the method to use for storing cache data; either "serialize" or "json"
     *
     * json is faster, but can't remember the class names (everything comes back 
     * as a "stdClass Object"; all the data is the same though. serialize is 
     * slower, but will have all the class info.
     *
     * defaults to 'serialize'
     */
    public $cache_serializer = 'serialize';

    /*
     * by default, according to RFC 1034
     *
     * CNAME RRs cause special action in DNS software.  When a name server
     * fails to find a desired RR in the resource set associated with the
     * domain name, it checks to see if the resource set consists of a CNAME
     * record with a matching class.  If so, the name server includes the CNAME
     * record in the response and restarts the query at the domain name
     * specified in the data field of the CNAME record.
     *
     * this can cause "unexpected" behavious, since i'm sure *most* people
     * don't know DNS does this; there may be cases where Net_DNS2 returns a
     * positive response, even though the hostname the user looked up did not
     * actually exist.
     *
     * strict_query_mode means that if the hostname that was looked up isn't
     * actually in the answer section of the response, Net_DNS2 will return an 
     * empty answer section, instead of an answer section that could contain 
     * CNAME records.
     *
     */
    public $strict_query_mode = false;

    /*
     * if we should set the recursion desired bit to 1 or 0.
     *
     * by default this is set to true, we want the DNS server to perform a recursive
     * request. If set to false, the RD bit will be set to 0, and the server will 
     * not perform recursion on the request.
     */
    public $recurse = true;

    /*
     * request DNSSEC values, by setting the DO flag to 1; this actually makes
     * the resolver add a OPT RR to the additional section, and sets the DO flag
     * in this RR to 1
     *
     */
    public $dnssec = false;

    /*
     * set the DNSSEC AD (Authentic Data) bit on/off; the AD bit on the request 
     * side was previously undefined, and resolvers we instructed to always clear 
     * the AD bit when sending a request.
     *
     * RFC6840 section 5.7 defines setting the AD bit in the query as a signal to
     * the server that it wants the value of the AD bit, without needed to request
     * all the DNSSEC data via the DO bit.
     *
     */
    public $dnssec_ad_flag = false;

    /*
     * set the DNSSEC CD (Checking Disabled) bit on/off; turning this off, means
     * that the DNS resolver will perform it's own signature validation- so the DNS
     * servers simply pass through all the details.
     *
     */
    public $dnssec_cd_flag = false;

    /*
     * the EDNS(0) UDP payload size to use when making DNSSEC requests
     * see RFC 4035 section 4.1 - EDNS Support.
     *
     * there is some different ideas on the suggest size to supprt; but it seems to
     * be "at least 1220 bytes, but SHOULD support 4000 bytes.
     *
     * we'll just support 4000
     *
     */
    public $dnssec_payload_size = 4000;

    /*
     * the last exeception that was generated
     */
    public $last_exception = null;

    /*
     * the list of exceptions by name server
     */
    public $last_exception_list = array();

    /*
     * name server list
     */
    public $nameservers = array();

    /*
     * local sockets
     */
    protected $sock = array(Net_DNS2_Socket::SOCK_DGRAM => array(), Net_DNS2_Socket::SOCK_STREAM => array());

    /*
     * if the socket extension is loaded
     */
    protected $sockets_enabled = false;

    /*
     * the TSIG or SIG RR object for authentication
     */
    protected $auth_signature = null;

    /*
     * the shared memory segment id for the local cache
     */
    protected $cache = null;

    /*
     * internal setting for enabling cache
     */
    protected $use_cache = false;

    /**
     * Constructor - base constructor for the Resolver and Updater
     *
     * @param mixed $options array of options or null for none
     *
     * @throws Net_DNS2_Exception
     * @access public
     *
     */
    public function __construct(array $options = null)
    {
        //
        // check for the sockets extension; we no longer support the sockets library under 
        // windows- there have been too many errors related to sockets under windows- 
        // specifically inconsistent socket defines between versions of windows- 
        //
        // and since I can't seem to find a way to get the actual windows version, it 
        // doesn't seem fixable in the code.
        //
        if ( (extension_loaded('sockets') == true) && (strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') ) {

            $this->sockets_enabled = true;
        }

        //
        // load any options that were provided
        //
        if (!empty($options)) {

            foreach ($options as $key => $value) {

                if ($key == 'nameservers') {

                    $this->setServers($value);
                } else {

                    $this->$key = $value;
                }
            }
        }

        //
        // if we're set to use the local shared memory cache, then
        // make sure it's been initialized
        //
        switch($this->cache_type) {
        case 'shared':
            if (extension_loaded('shmop')) {

                $this->cache = new Net_DNS2_Cache_Shm;
                $this->use_cache = true;
            } else {

                throw new Net_DNS2_Exception(
                    'shmop library is not available for cache',
                    Net_DNS2_Lookups::E_CACHE_SHM_UNAVAIL
                );
            }
            break;
        case 'file':

            $this->cache = new Net_DNS2_Cache_File;
            $this->use_cache = true;

            break;  
        case 'none':
            $this->use_cache = false;
            break;
        default:

            throw new Net_DNS2_Exception(
                'un-supported cache type: ' . $this->cache_type,
                Net_DNS2_Lookups::E_CACHE_UNSUPPORTED
            );
        }
    }

    /**
     * autoload call-back function; used to auto-load classes
     *
     * @param string $name the name of the class
     *
     * @return void
     * @access public
     *
     */
    static public function autoload($name)
    {
        //
        // only auto-load our classes
        //
        if (strncmp($name, 'Net_DNS2', 8) == 0) {

            include str_replace('_', '/', $name) . '.php';
        }

        return;
    }

    /**
     * sets the name servers to be used
     *
     * @param mixed $nameservers either an array of name servers, or a file name 
     *                           to parse, assuming it's in the resolv.conf format
     *
     * @return boolean
     * @throws Net_DNS2_Exception
     * @access public
     *
     */
    public function setServers($nameservers)
    {
        //
        // if it's an array, then use it directly
        //
        // otherwise, see if it's a path to a resolv.conf file and if so, load it
        //
        if (is_array($nameservers)) {

            $this->nameservers = $nameservers;

        } else {

            //
            // temporary list of name servers; do it this way rather than just 
            // resetting the local nameservers value, just incase an exception 
            // is thrown here; this way we might avoid ending up with an empty 
            // namservers list.
            //
            $ns = array();

            //
            // check to see if the file is readable
            //
            if (is_readable($nameservers) === true) {
    
                $data = file_get_contents($nameservers);
                if ($data === false) {
                    throw new Net_DNS2_Exception(
                        'failed to read contents of file: ' . $nameservers,
                        Net_DNS2_Lookups::E_NS_INVALID_FILE
                    );
                }

                $lines = explode("\n", $data);

                foreach ($lines as $line) {
                    
                    $line = trim($line);

                    //
                    // ignore empty lines, and lines that are commented out
                    //
                    if ( (strlen($line) == 0) 
                        || ($line[0] == '#') 
                        || ($line[0] == ';')
                    ) {
                        continue;
                    }

                    //
                    // ignore lines with no spaces in them.
                    //
                    if (strpos($line, ' ') === false) {
                        continue;
                    }

                    list($key, $value) = preg_split('/\s+/', $line, 2);

                    $key    = trim(strtolower($key));
                    $value  = trim(strtolower($value));

                    switch($key) {
                    case 'nameserver':

                        //
                        // nameserver can be a IPv4 or IPv6 address
                        //
                        if ( (self::isIPv4($value) == true) 
                            || (self::isIPv6($value) == true)
                        ) {

                            $ns[] = $value;
                        } else {

                            throw new Net_DNS2_Exception(
                                'invalid nameserver entry: ' . $value,
                                Net_DNS2_Lookups::E_NS_INVALID_ENTRY
                            );
                        }
                        break;

                    case 'domain':
                        $this->domain = $value;
                        break;

                    case 'search':
                        $this->search_list = preg_split('/\s+/', $value);
                        break;

                    case 'options':
                        $this->parseOptions($value);
                        break;

                    default:
                        ;
                    }
                }

                //
                // if we don't have a domain, but we have a search list, then
                // take the first entry on the search list as the domain
                //
                if ( (strlen($this->domain) == 0) 
                    && (count($this->search_list) > 0) 
                ) {
                    $this->domain = $this->search_list[0];
                }

            } else {
                throw new Net_DNS2_Exception(
                    'resolver file file provided is not readable: ' . $nameservers,
                    Net_DNS2_Lookups::E_NS_INVALID_FILE
                );
            }

            //
            // store the name servers locally
            //
            if (count($ns) > 0) {
                $this->nameservers = $ns;
            }
        }

        //
        // remove any duplicates; not sure if we should bother with this- if people
        // put duplicate name servers, who I am to stop them?
        //
        $this->nameservers = array_unique($this->nameservers);

        //
        // check the name servers
        //
        $this->checkServers();

        return true;
    }

    /**
     * parses the options line from a resolv.conf file; we don't support all the options
     * yet, and using them is optional.
     *
     * @param string $value is the options string from the resolv.conf file.
     *
     * @return boolean
     * @access private
     *
     */
    private function parseOptions($value)
    {
        //
        // if overrides are disabled (the default), or the options list is empty for some
        // reason, then we don't need to do any of this work.
        //
        if ( ($this->use_resolv_options == false) || (strlen($value) == 0) ) {

            return true;
        }

        $options = preg_split('/\s+/', strtolower($value));

        foreach ($options as $option) {

            //
            // override the timeout value from the resolv.conf file.
            //
            if ( (strncmp($option, 'timeout', 7) == 0) && (strpos($option, ':') !== false) ) {

                list($key, $val) = explode(':', $option);

                if ( ($val > 0) && ($val <= 30) ) {

                    $this->timeout = $val;
                }

            //
            // the rotate option just enabled the ns_random option
            //
            } else if (strncmp($option, 'rotate', 6) == 0) {

                $this->ns_random = true;
            }
        }

        return true;
    }    

    /**
     * checks the list of name servers to make sure they're set
     *
     * @param mixed $default a path to a resolv.conf file or an array of servers.
     *
     * @return boolean
     * @throws Net_DNS2_Exception
     * @access protected
     *
     */
    protected function checkServers($default = null)
    {
        if (empty($this->nameservers)) {

            if (isset($default)) {

                $this->setServers($default);
            } else {

                throw new Net_DNS2_Exception(
                    'empty name servers list; you must provide a list of name '.
                    'servers, or the path to a resolv.conf file.',
                    Net_DNS2_Lookups::E_NS_INVALID_ENTRY
                );
            }
        }
    
        return true;
    }

    /**
     * adds a TSIG RR object for authentication
     *
     * @param string $keyname   the key name to use for the TSIG RR
     * @param string $signature the key to sign the request.
     * @param string $algorithm the algorithm to use
     * 
     * @return boolean
     * @access public
     * @since  function available since release 1.1.0
     *
     */
    public function signTSIG(
        $keyname, $signature = '', $algorithm = Net_DNS2_RR_TSIG::HMAC_MD5
    ) {
        //
        // if the TSIG was pre-created and passed in, then we can just used 
        // it as provided.
        //
        if ($keyname instanceof Net_DNS2_RR_TSIG) {

            $this->auth_signature = $keyname;

        } else {

            //
            // otherwise create the TSIG RR, but don't add it just yet; TSIG needs 
            // to be added as the last additional entry- so we'll add it just 
            // before we send.
            //
            $this->auth_signature = Net_DNS2_RR::fromString(
                strtolower(trim($keyname)) .
                ' TSIG '. $signature
            );

            //
            // set the algorithm to use
            //
            $this->auth_signature->algorithm = $algorithm;
        }
          
        return true;
    }

    /**
     * adds a SIG RR object for authentication
     *
     * @param string $filename the name of a file to load the signature from.
     * 
     * @return boolean
     * @throws Net_DNS2_Exception
     * @access public
     * @since  function available since release 1.1.0
     *
     */
    public function signSIG0($filename)
    {
        //
        // check for OpenSSL
        //
        if (extension_loaded('openssl') === false) {
            
            throw new Net_DNS2_Exception(
                'the OpenSSL extension is required to use SIG(0).',
                Net_DNS2_Lookups::E_OPENSSL_UNAVAIL
            );
        }

        //
        // if the SIG was pre-created, then use it as-is
        //
        if ($filename instanceof Net_DNS2_RR_SIG) {

            $this->auth_signature = $filename;

        } else {
        
            //
            // otherwise, it's filename which needs to be parsed and processed.
            //
            $private = new Net_DNS2_PrivateKey($filename);

            //
            // create a new Net_DNS2_RR_SIG object
            //
            $this->auth_signature = new Net_DNS2_RR_SIG();

            //
            // reset some values
            //
            $this->auth_signature->name         = $private->signname;
            $this->auth_signature->ttl          = 0;
            $this->auth_signature->class        = 'ANY';

            //
            // these values are pulled from the private key
            //
            $this->auth_signature->algorithm    = $private->algorithm;
            $this->auth_signature->keytag       = $private->keytag;
            $this->auth_signature->signname     = $private->signname;

            //
            // these values are hard-coded for SIG0
            //
            $this->auth_signature->typecovered  = 'SIG0';
            $this->auth_signature->labels       = 0;
            $this->auth_signature->origttl      = 0;

            //
            // generate the dates
            //
            $t = time();

            $this->auth_signature->sigincep     = gmdate('YmdHis', $t);
            $this->auth_signature->sigexp       = gmdate('YmdHis', $t + 500);

            //
            // store the private key in the SIG object for later.
            //
            $this->auth_signature->private_key  = $private;
        }

        //
        // only RSA algorithms are supported for SIG(0)
        //
        switch($this->auth_signature->algorithm) {
        case Net_DNS2_Lookups::DNSSEC_ALGORITHM_RSAMD5:
        case Net_DNS2_Lookups::DNSSEC_ALGORITHM_RSASHA1:
        case Net_DNS2_Lookups::DNSSEC_ALGORITHM_RSASHA256:
        case Net_DNS2_Lookups::DNSSEC_ALGORITHM_RSASHA512:
        case Net_DNS2_Lookups::DNSSEC_ALGORITHM_DSA:
            break;
        default:
            throw new Net_DNS2_Exception(
                'only asymmetric algorithms work with SIG(0)!',
                Net_DNS2_Lookups::E_OPENSSL_INV_ALGO
            );
        }

        return true;
    }

    /**
     * a simple function to determine if the RR type is cacheable
     *
     * @param stream $_type the RR type string
     *
     * @return bool returns true/false if the RR type if cachable
     * @access public
     *
     */
    public function cacheable($_type)
    {
        switch($_type) {
        case 'AXFR':
        case 'OPT':
            return false;
        }

        return true;   
    }

    /**
     * PHP doesn't support unsigned integers, but many of the RR's return
     * unsigned values (like SOA), so there is the possibility that the
     * value will overrun on 32bit systems, and you'll end up with a 
     * negative value.
     *
     * 64bit systems are not affected, as their PHP_IN_MAX value should
     * be 64bit (ie 9223372036854775807)
     *
     * This function returns a negative integer value, as a string, with
     * the correct unsigned value.
     *
     * @param string $_int the unsigned integer value to check
     *
     * @return string returns the unsigned value as a string.
     * @access public
     *
     */
    public static function expandUint32($_int)
    {
        if ( ($_int < 0) && (PHP_INT_MAX == 2147483647) ) {
            return sprintf('%u', $_int);
        } else {
            return $_int;
        }
    }

    /**
     * returns true/false if the given address is a valid IPv4 address
     *
     * @param string $_address the IPv4 address to check
     *
     * @return boolean returns true/false if the address is IPv4 address
     * @access public
     *
     */
    public static function isIPv4($_address)
    {
        //
        // use filter_var() if it's available; it's faster than preg
        //
        if (extension_loaded('filter') == true) {

            if (filter_var($_address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) == false) {
                return false;
            }
        } else {

            //
            // do the main check here;
            //
            if (inet_pton($_address) === false) {
                return false;
            }

            //
            // then make sure we're not a IPv6 address
            //
            if (preg_match('/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/', $_address) == 0) {
                return false;
            }
        }

        return true;
    }
    
    /**
     * returns true/false if the given address is a valid IPv6 address
     *
     * @param string $_address the IPv6 address to check
     *
     * @return boolean returns true/false if the address is IPv6 address
     * @access public
     *
     */
    public static function isIPv6($_address)
    {
        //
        // use filter_var() if it's available; it's faster than preg
        //
        if (extension_loaded('filter') == true) {
            if (filter_var($_address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) == false) {
                return false;
            }
        } else {

            //
            // do the main check here
            //
            if (inet_pton($_address) === false) {
                return false;
            }

            //
            // then make sure it doesn't match a IPv4 address
            //
            if (preg_match('/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/', $_address) == 1) {
                return false;
            }
        }

        return true;
    }

    /**
     * formats the given IPv6 address as a fully expanded IPv6 address
     *
     * @param string $_address the IPv6 address to expand
     *
     * @return string the fully expanded IPv6 address
     * @access public
     *
     */
    public static function expandIPv6($_address)
    {
        $hex = unpack('H*hex', inet_pton($_address));
    
        return substr(preg_replace('/([A-f0-9]{4})/', "$1:", $hex['hex']), 0, -1);
    }

    /**
     * sends a standard Net_DNS2_Packet_Request packet
     *
     * @param Net_DNS2_Packet $request a Net_DNS2_Packet_Request object
     * @param boolean         $use_tcp true/false if the function should
     *                                 use TCP for the request
     *
     * @return mixed returns a Net_DNS2_Packet_Response object, or false on error
     * @throws Net_DNS2_Exception
     * @access protected
     *
     */
    protected function sendPacket(Net_DNS2_Packet $request, $use_tcp)
    {
        //
        // get the data from the packet
        //
        $data = $request->get();
        if (strlen($data) < Net_DNS2_Lookups::DNS_HEADER_SIZE) {

            throw new Net_DNS2_Exception(
                'invalid or empty packet for sending!',
                Net_DNS2_Lookups::E_PACKET_INVALID,
                null,
                $request
            );
        }

        reset($this->nameservers);
        
        //
        // randomize the name server list if it's asked for
        //
        if ($this->ns_random == true) {

            shuffle($this->nameservers);
        }

        //
        // loop so we can handle server errors
        //
        $response = null;
        $ns = '';

        while (1) {

            //
            // grab the next DNS server
            //
            $ns = current($this->nameservers);
            next($this->nameservers);

            if ($ns === false) {

                if (is_null($this->last_exception) == false) {

                    throw $this->last_exception;
                } else {

                    throw new Net_DNS2_Exception(
                        'every name server provided has failed',
                        Net_DNS2_Lookups::E_NS_FAILED
                    );
                }
            }

            //
            // if the use TCP flag (force TCP) is set, or the packet is bigger than our 
            // max allowed UDP size- which is either 512, or if this is DNSSEC request,
            // then whatever the configured dnssec_payload_size is.
            //
            $max_udp_size = Net_DNS2_Lookups::DNS_MAX_UDP_SIZE;
            if ($this->dnssec == true)
            {
                $max_udp_size = $this->dnssec_payload_size;
            }

            if ( ($use_tcp == true) || (strlen($data) > $max_udp_size) ) {

                try
                {
                    $response = $this->sendTCPRequest($ns, $data, ($request->question[0]->qtype == 'AXFR') ? true : false);

                } catch(Net_DNS2_Exception $e) {

                    $this->last_exception = $e;
                    $this->last_exception_list[$ns] = $e;

                    continue;
                }

            //
            // otherwise, send it using UDP
            //
            } else {

                try
                {
                    $response = $this->sendUDPRequest($ns, $data);

                    //
                    // check the packet header for a trucated bit; if it was truncated,
                    // then re-send the request as TCP.
                    //
                    if ($response->header->tc == 1) {

                        $response = $this->sendTCPRequest($ns, $data);
                    }

                } catch(Net_DNS2_Exception $e) {

                    $this->last_exception = $e;
                    $this->last_exception_list[$ns] = $e;

                    continue;
                }
            }

            //
            // make sure header id's match between the request and response
            //
            if ($request->header->id != $response->header->id) {

                $this->last_exception = new Net_DNS2_Exception(

                    'invalid header: the request and response id do not match.',
                    Net_DNS2_Lookups::E_HEADER_INVALID,
                    null,
                    $request,
                    $response
                );

                $this->last_exception_list[$ns] = $this->last_exception;
                continue;
            }

            //
            // make sure the response is actually a response
            // 
            // 0 = query, 1 = response
            //
            if ($response->header->qr != Net_DNS2_Lookups::QR_RESPONSE) {
            
                $this->last_exception = new Net_DNS2_Exception(

                    'invalid header: the response provided is not a response packet.',
                    Net_DNS2_Lookups::E_HEADER_INVALID,
                    null,
                    $request,
                    $response
                );

                $this->last_exception_list[$ns] = $this->last_exception;
                continue;
            }

            //
            // make sure the response code in the header is ok
            //
            if ($response->header->rcode != Net_DNS2_Lookups::RCODE_NOERROR) {
            
                $this->last_exception = new Net_DNS2_Exception(
                
                    'DNS request failed: ' . 
                    Net_DNS2_Lookups::$result_code_messages[$response->header->rcode],
                    $response->header->rcode,
                    null,
                    $request,
                    $response
                );

                $this->last_exception_list[$ns] = $this->last_exception;
                continue;
            }

            break;
        }

        return $response;
    }

    /**
     * cleans up a failed socket and throws the given exception
     *
     * @param string  $_proto the protocol of the socket
     * @param string  $_ns    the name server to use for the request
     * @param string  $_error the error message to throw at the end of the function
     *
     * @throws Net_DNS2_Exception
     * @access private
     *
     */
    private function generateError($_proto, $_ns, $_error)
    {
        if (isset($this->sock[$_proto][$_ns]) == false)
        {
            throw new Net_DNS2_Exception('invalid socket referenced', Net_DNS2_Lookups::E_NS_INVALID_SOCKET);
        }
        
        //
        // grab the last error message off the socket
        //
        $last_error = $this->sock[$_proto][$_ns]->last_error;
        
        //
        // close it
        //
        $this->sock[$_proto][$_ns]->close();

        //
        // remove it from the socket cache
        //
        unset($this->sock[$_proto][$_ns]);

        //
        // throw the error provided
        //
        throw new Net_DNS2_Exception($last_error, $_error);
    }

    /**
     * sends a DNS request using TCP
     *
     * @param string  $_ns   the name server to use for the request
     * @param string  $_data the raw DNS packet data
     * @param boolean $_axfr if this is a zone transfer request
     *
     * @return Net_DNS2_Packet_Response the reponse object
     * @throws Net_DNS2_Exception
     * @access private
     *
     */
    private function sendTCPRequest($_ns, $_data, $_axfr = false)
    {
        //
        // grab the start time
        //
        $start_time = microtime(true);

        //
        // see if we already have an open socket from a previous request; if so, try to use
        // that instead of opening a new one.
        //
        if ( (!isset($this->sock[Net_DNS2_Socket::SOCK_STREAM][$_ns]))
            || (!($this->sock[Net_DNS2_Socket::SOCK_STREAM][$_ns] instanceof Net_DNS2_Socket))
        ) {

            //
            // if the socket library is available, then use that
            //
            if ($this->sockets_enabled === true) {

                $this->sock[Net_DNS2_Socket::SOCK_STREAM][$_ns] = new Net_DNS2_Socket_Sockets(
                    Net_DNS2_Socket::SOCK_STREAM, $_ns, $this->dns_port, $this->timeout
                );

            //
            // otherwise the streams library
            //
            } else {

                $this->sock[Net_DNS2_Socket::SOCK_STREAM][$_ns] = new Net_DNS2_Socket_Streams(
                    Net_DNS2_Socket::SOCK_STREAM, $_ns, $this->dns_port, $this->timeout
                );
            }

            //
            // if a local IP address / port is set, then add it
            //
            if (strlen($this->local_host) > 0) {

                $this->sock[Net_DNS2_Socket::SOCK_STREAM][$_ns]->bindAddress(
                    $this->local_host, $this->local_port
                );
            }

            //
            // open the socket
            //
            if ($this->sock[Net_DNS2_Socket::SOCK_STREAM][$_ns]->open() === false) {

                $this->generateError(Net_DNS2_Socket::SOCK_STREAM, $_ns, Net_DNS2_Lookups::E_NS_SOCKET_FAILED);
            }
        }

        //
        // write the data to the socket; if it fails, continue on
        // the while loop
        //
        if ($this->sock[Net_DNS2_Socket::SOCK_STREAM][$_ns]->write($_data) === false) {

            $this->generateError(Net_DNS2_Socket::SOCK_STREAM, $_ns, Net_DNS2_Lookups::E_NS_SOCKET_FAILED);
        }

        //
        // read the content, using select to wait for a response
        //
        $size = 0;
        $result = null;
        $response = null;

        //
        // handle zone transfer requests differently than other requests.
        //
        if ($_axfr == true) {

            $soa_count = 0;

            while (1) {

                //
                // read the data off the socket
                //
                $result = $this->sock[Net_DNS2_Socket::SOCK_STREAM][$_ns]->read($size, ($this->dnssec == true) ? $this->dnssec_payload_size : Net_DNS2_Lookups::DNS_MAX_UDP_SIZE);
                if ( ($result === false) || ($size < Net_DNS2_Lookups::DNS_HEADER_SIZE) ) {

                    //
                    // if we get an error, then keeping this socket around for a future request, could cause
                    // an error- for example, https://github.com/mikepultz/netdns2/issues/61
                    //
                    // in this case, the connection was timing out, which once it did finally respond, left
                    // data on the socket, which could be captured on a subsequent request.
                    //
                    // since there's no way to "reset" a socket, the only thing we can do it close it.
                    //
                    $this->generateError(Net_DNS2_Socket::SOCK_STREAM, $_ns, Net_DNS2_Lookups::E_NS_SOCKET_FAILED);
                }

                //
                // parse the first chunk as a packet
                //
                $chunk = new Net_DNS2_Packet_Response($result, $size);

                //
                // if this is the first packet, then clone it directly, then
                // go through it to see if there are two SOA records
                // (indicating that it's the only packet)
                //
                if (is_null($response) == true) {

                    $response = clone $chunk;

                    //
                    // look for a failed response; if the zone transfer
                    // failed, then we don't need to do anything else at this
                    // point, and we should just break out.                 
                    //
                    if ($response->header->rcode != Net_DNS2_Lookups::RCODE_NOERROR) {
                        break;
                    }

                    //   
                    // go through each answer
                    //
                    foreach ($response->answer as $index => $rr) {

                        //
                        // count the SOA records
                        //
                        if ($rr->type == 'SOA') {
                            $soa_count++;
                        }
                    }

                    //
                    // if we have 2 or more SOA records, then we're done;
                    // otherwise continue out so we read the rest of the 
                    // packets off the socket
                    //
                    if ($soa_count >= 2) {
                        break;
                    } else {
                        continue;
                    }

                } else {

                    //
                    // go through all these answers, and look for SOA records
                    //
                    foreach ($chunk->answer as $index => $rr) {

                        //
                        // count the number of SOA records we find
                        //
                        if ($rr->type == 'SOA') {
                            $soa_count++;           
                        }

                        //
                        // add the records to a single response object
                        //
                        $response->answer[] = $rr;                  
                    }

                    //
                    // if we've found the second SOA record, we're done
                    //
                    if ($soa_count >= 2) {
                        break;
                    }
                }
            }

        //
        // everything other than a AXFR
        //
        } else {

            $result = $this->sock[Net_DNS2_Socket::SOCK_STREAM][$_ns]->read($size, ($this->dnssec == true) ? $this->dnssec_payload_size : Net_DNS2_Lookups::DNS_MAX_UDP_SIZE);
            if ( ($result === false) || ($size < Net_DNS2_Lookups::DNS_HEADER_SIZE) ) {

                $this->generateError(Net_DNS2_Socket::SOCK_STREAM, $_ns, Net_DNS2_Lookups::E_NS_SOCKET_FAILED);
            }

            //
            // create the packet object
            //
            $response = new Net_DNS2_Packet_Response($result, $size);
        }

        //
        // store the query time
        //
        $response->response_time = microtime(true) - $start_time;

        //
        // add the name server that the response came from to the response object,
        // and the socket type that was used.
        //
        $response->answer_from = $_ns;
        $response->answer_socket_type = Net_DNS2_Socket::SOCK_STREAM;

        //
        // return the Net_DNS2_Packet_Response object
        //
        return $response;
    }

    /**
     * sends a DNS request using UDP
     *
     * @param string  $_ns   the name server to use for the request
     * @param string  $_data the raw DNS packet data
     *
     * @return Net_DNS2_Packet_Response the reponse object
     * @throws Net_DNS2_Exception
     * @access private
     *
     */
    private function sendUDPRequest($_ns, $_data)
    {
        //
        // grab the start time
        //
        $start_time = microtime(true);

        //
        // see if we already have an open socket from a previous request; if so, try to use
        // that instead of opening a new one.
        //
        if ( (!isset($this->sock[Net_DNS2_Socket::SOCK_DGRAM][$_ns]))
            || (!($this->sock[Net_DNS2_Socket::SOCK_DGRAM][$_ns] instanceof Net_DNS2_Socket))
        ) {

            //
            // if the socket library is available, then use that
            //
            if ($this->sockets_enabled === true) {

                $this->sock[Net_DNS2_Socket::SOCK_DGRAM][$_ns] = new Net_DNS2_Socket_Sockets(
                    Net_DNS2_Socket::SOCK_DGRAM, $_ns, $this->dns_port, $this->timeout
                );

            //
            // otherwise the streams library
            //
            } else {

                $this->sock[Net_DNS2_Socket::SOCK_DGRAM][$_ns] = new Net_DNS2_Socket_Streams(
                    Net_DNS2_Socket::SOCK_DGRAM, $_ns, $this->dns_port, $this->timeout
                );
            }

            //
            // if a local IP address / port is set, then add it
            //
            if (strlen($this->local_host) > 0) {

                $this->sock[Net_DNS2_Socket::SOCK_DGRAM][$_ns]->bindAddress(
                    $this->local_host, $this->local_port
                );
            }

            //
            // open the socket
            //
            if ($this->sock[Net_DNS2_Socket::SOCK_DGRAM][$_ns]->open() === false) {

                $this->generateError(Net_DNS2_Socket::SOCK_DGRAM, $_ns, Net_DNS2_Lookups::E_NS_SOCKET_FAILED);
            }
        }

        //
        // write the data to the socket
        //
        if ($this->sock[Net_DNS2_Socket::SOCK_DGRAM][$_ns]->write($_data) === false) {

            $this->generateError(Net_DNS2_Socket::SOCK_DGRAM, $_ns, Net_DNS2_Lookups::E_NS_SOCKET_FAILED);
        }

        //
        // read the content, using select to wait for a response
        //
        $size = 0;

        $result = $this->sock[Net_DNS2_Socket::SOCK_DGRAM][$_ns]->read($size, ($this->dnssec == true) ? $this->dnssec_payload_size : Net_DNS2_Lookups::DNS_MAX_UDP_SIZE);
        if (( $result === false) || ($size < Net_DNS2_Lookups::DNS_HEADER_SIZE)) {

            $this->generateError(Net_DNS2_Socket::SOCK_DGRAM, $_ns, Net_DNS2_Lookups::E_NS_SOCKET_FAILED);
        }

        //
        // create the packet object
        //
        $response = new Net_DNS2_Packet_Response($result, $size);

        //
        // store the query time
        //
        $response->response_time = microtime(true) - $start_time;

        //
        // add the name server that the response came from to the response object,
        // and the socket type that was used.
        //
        $response->answer_from = $_ns;
        $response->answer_socket_type = Net_DNS2_Socket::SOCK_DGRAM;

        //
        // return the Net_DNS2_Packet_Response object
        //
        return $response;
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

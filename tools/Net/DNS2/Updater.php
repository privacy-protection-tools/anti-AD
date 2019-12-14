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
 * The main dynamic DNS updater class.
 *
 * This class provices functions to handle all defined dynamic DNS update 
 * requests as defined by RFC 2136.
 *
 * This is separate from the Net_DNS2_Resolver class, as while the underlying
 * protocol is the same, the functionality is completely different.
 *
 * Generally, query (recursive) lookups are done against caching server, while
 * update requests are done against authoratative servers.
 * 
 * @category Networking
 * @package  Net_DNS2
 * @author   Mike Pultz <mike@mikepultz.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link     http://pear.php.net/package/Net_DNS2
 * @see      Net_DNS2
 *
 */
class Net_DNS2_Updater extends Net_DNS2
{
    /*
     * a Net_DNS2_Packet_Request object used for the update request
     */
    private $_packet;

    /**
     * Constructor - builds a new Net_DNS2_Updater objected used for doing 
     * dynamic DNS updates
     *
     * @param string $zone    the domain name to use for DNS updates
     * @param mixed  $options an array of config options or null
     *
     * @throws Net_DNS2_Exception
     * @access public
     *
     */
    public function __construct($zone, array $options = null)
    {
        parent::__construct($options);

        //
        // create the packet
        //
        $this->_packet = new Net_DNS2_Packet_Request(
            strtolower(trim($zone, " \n\r\t.")), 'SOA', 'IN'
        );

        //
        // make sure the opcode on the packet is set to UPDATE
        //
        $this->_packet->header->opcode = Net_DNS2_Lookups::OPCODE_UPDATE;
    }

    /**
     * checks that the given name matches the name for the zone we're updating
     *
     * @param string $name The name to be checked.
     *
     * @return boolean
     * @throws Net_DNS2_Exception
     * @access private
     *
     */
    private function _checkName($name)
    {
        if (!preg_match('/' . $this->_packet->question[0]->qname . '$/', $name)) {
            
            throw new Net_DNS2_Exception(
                'name provided (' . $name . ') does not match zone name (' .
                $this->_packet->question[0]->qname . ')',
                Net_DNS2_Lookups::E_PACKET_INVALID
            );
        }
    
        return true;
    }

    /**
     * add a signature to the request for authentication 
     *
     * @param string $keyname   the key name to use for the TSIG RR
     * @param string $signature the key to sign the request.
     *
     * @return     boolean
     * @access     public
     * @see        Net_DNS2::signTSIG()
     * @deprecated function deprecated in 1.1.0
     *
     */
    public function signature($keyname, $signature)
    {
        return $this->signTSIG($keyname, $signature);
    }

    /**
     *   2.5.1 - Add To An RRset
     *
     *   RRs are added to the Update Section whose NAME, TYPE, TTL, RDLENGTH
     *   and RDATA are those being added, and CLASS is the same as the zone
     *   class.  Any duplicate RRs will be silently ignored by the primary
     *   master.
     *
     * @param Net_DNS2_RR $rr the Net_DNS2_RR object to be added to the zone
     *
     * @return boolean
     * @throws Net_DNS2_Exception
     * @access public
     *
     */
    public function add(Net_DNS2_RR $rr)
    {
        $this->_checkName($rr->name);

        //
        // add the RR to the "update" section
        //
        if (!in_array($rr, $this->_packet->authority)) {
            $this->_packet->authority[] = $rr;
        }

        return true;
    }

    /**
     *   2.5.4 - Delete An RR From An RRset
     *
     *   RRs to be deleted are added to the Update Section.  The NAME, TYPE,
     *   RDLENGTH and RDATA must match the RR being deleted.  TTL must be
     *   specified as zero (0) and will otherwise be ignored by the primary
     *   master.  CLASS must be specified as NONE to distinguish this from an
     *   RR addition.  If no such RRs exist, then this Update RR will be
     *   silently ignored by the primary master.
     *
     * @param Net_DNS2_RR $rr the Net_DNS2_RR object to be deleted from the zone
     *
     * @return boolean
     * @throws Net_DNS2_Exception
     * @access public
     *
     */
    public function delete(Net_DNS2_RR $rr)
    {
        $this->_checkName($rr->name);

        $rr->ttl    = 0;
        $rr->class  = 'NONE';

        //
        // add the RR to the "update" section
        //
        if (!in_array($rr, $this->_packet->authority)) {
            $this->_packet->authority[] = $rr;
        }

        return true;
    }

    /**
     *   2.5.2 - Delete An RRset
     *
     *   One RR is added to the Update Section whose NAME and TYPE are those
     *   of the RRset to be deleted.  TTL must be specified as zero (0) and is
     *   otherwise not used by the primary master.  CLASS must be specified as
     *   ANY.  RDLENGTH must be zero (0) and RDATA must therefore be empty.
     *   If no such RRset exists, then this Update RR will be silently ignored
     *   by the primary master
     *
     * @param string $name the RR name to be removed from the zone
     * @param string $type the RR type to be removed from the zone
     *
     * @return boolean
     * @throws Net_DNS2_Exception
     * @access public
     *
     */
    public function deleteAny($name, $type)
    {
        $this->_checkName($name);

        $class = Net_DNS2_Lookups::$rr_types_id_to_class[
            Net_DNS2_Lookups::$rr_types_by_name[$type]
        ];
        if (!isset($class)) {

            throw new Net_DNS2_Exception(
                'unknown or un-supported resource record type: ' . $type,
                Net_DNS2_Lookups::E_RR_INVALID
            );
        }
    
        $rr = new $class;

        $rr->name       = $name;
        $rr->ttl        = 0;
        $rr->class      = 'ANY';
        $rr->rdlength   = -1;
        $rr->rdata      = '';    

        //
        // add the RR to the "update" section
        //
        if (!in_array($rr, $this->_packet->authority)) {
            $this->_packet->authority[] = $rr;
        }

        return true;
    }

    /**
     *   2.5.3 - Delete All RRsets From A Name
     *
     *   One RR is added to the Update Section whose NAME is that of the name
     *   to be cleansed of RRsets.  TYPE must be specified as ANY.  TTL must
     *   be specified as zero (0) and is otherwise not used by the primary
     *   master.  CLASS must be specified as ANY.  RDLENGTH must be zero (0)
     *   and RDATA must therefore be empty.  If no such RRsets exist, then
     *   this Update RR will be silently ignored by the primary master.
     *
     * @param string $name the RR name to be removed from the zone
     *
     * @return boolean
     * @throws Net_DNS2_Exception
     * @access public
     *
     */
    public function deleteAll($name)
    {
        $this->_checkName($name);

        //
        // the Net_DNS2_RR_ANY class is just an empty stub class used for these
        // cases only
        //
        $rr = new Net_DNS2_RR_ANY;

        $rr->name       = $name;
        $rr->ttl        = 0;
        $rr->type       = 'ANY';
        $rr->class      = 'ANY';
        $rr->rdlength   = -1;
        $rr->rdata      = '';

        //
        // add the RR to the "update" section
        //
        if (!in_array($rr, $this->_packet->authority)) {
            $this->_packet->authority[] = $rr;
        }

        return true;
    }

    /**
     *   2.4.1 - RRset Exists (Value Independent)
     *
     *   At least one RR with a specified NAME and TYPE (in the zone and class
     *   specified in the Zone Section) must exist.
     *
     *   For this prerequisite, a requestor adds to the section a single RR
     *   whose NAME and TYPE are equal to that of the zone RRset whose
     *   existence is required.  RDLENGTH is zero and RDATA is therefore
     *   empty.  CLASS must be specified as ANY to differentiate this
     *   condition from that of an actual RR whose RDLENGTH is naturally zero
     *   (0) (e.g., NULL).  TTL is specified as zero (0).
     *
     * @param string $name the RR name for the prerequisite
     * @param string $type the RR type for the prerequisite
     *
     * @return boolean
     * @throws Net_DNS2_Exception
     * @access public
     *
     */
    public function checkExists($name, $type)
    {
        $this->_checkName($name);
        
        $class = Net_DNS2_Lookups::$rr_types_id_to_class[
            Net_DNS2_Lookups::$rr_types_by_name[$type]
        ];
        if (!isset($class)) {

            throw new Net_DNS2_Exception(
                'unknown or un-supported resource record type: ' . $type,
                Net_DNS2_Lookups::E_RR_INVALID
            );
        }
    
        $rr = new $class;

        $rr->name       = $name;
        $rr->ttl        = 0;
        $rr->class      = 'ANY';
        $rr->rdlength   = -1;
        $rr->rdata      = '';    

        //
        // add the RR to the "prerequisite" section
        //
        if (!in_array($rr, $this->_packet->answer)) {
            $this->_packet->answer[] = $rr;
        }

        return true;
    }

    /**
     *   2.4.2 - RRset Exists (Value Dependent)
     *
     *   A set of RRs with a specified NAME and TYPE exists and has the same
     *   members with the same RDATAs as the RRset specified here in this
     *   section.  While RRset ordering is undefined and therefore not
     *   significant to this comparison, the sets be identical in their
     *   extent.
     *
     *   For this prerequisite, a requestor adds to the section an entire
     *   RRset whose preexistence is required.  NAME and TYPE are that of the
     *   RRset being denoted.  CLASS is that of the zone.  TTL must be
     *   specified as zero (0) and is ignored when comparing RRsets for
     *   identity.
     *
     * @param Net_DNS2_RR $rr the RR object to be used as a prerequisite
     *
     * @return boolean
     * @throws Net_DNS2_Exception
     * @access public
     *
     */
    public function checkValueExists(Net_DNS2_RR $rr)
    {
        $this->_checkName($rr->name);

        $rr->ttl = 0;

        //
        // add the RR to the "prerequisite" section
        //
        if (!in_array($rr, $this->_packet->answer)) {
            $this->_packet->answer[] = $rr;
        }

        return true;
    }

    /**
     *   2.4.3 - RRset Does Not Exist
     *
     *   No RRs with a specified NAME and TYPE (in the zone and class denoted
     *   by the Zone Section) can exist.
     *
     *   For this prerequisite, a requestor adds to the section a single RR
     *   whose NAME and TYPE are equal to that of the RRset whose nonexistence
     *   is required.  The RDLENGTH of this record is zero (0), and RDATA
     *   field is therefore empty.  CLASS must be specified as NONE in order
     *   to distinguish this condition from a valid RR whose RDLENGTH is
     *   naturally zero (0) (for example, the NULL RR).  TTL must be specified
     *   as zero (0).
     *
     * @param string $name the RR name for the prerequisite
     * @param string $type the RR type for the prerequisite
     *
     * @return boolean
     * @throws Net_DNS2_Exception
     * @access public
     *
     */
    public function checkNotExists($name, $type)
    {
        $this->_checkName($name);

        $class = Net_DNS2_Lookups::$rr_types_id_to_class[
            Net_DNS2_Lookups::$rr_types_by_name[$type]
        ];
        if (!isset($class)) {

            throw new Net_DNS2_Exception(
                'unknown or un-supported resource record type: ' . $type,
                Net_DNS2_Lookups::E_RR_INVALID
            );
        }
    
        $rr = new $class;

        $rr->name       = $name;
        $rr->ttl        = 0;
        $rr->class      = 'NONE';
        $rr->rdlength   = -1;
        $rr->rdata      = '';    

        //
        // add the RR to the "prerequisite" section
        //
        if (!in_array($rr, $this->_packet->answer)) {
            $this->_packet->answer[] = $rr;
        }

        return true;
    }

    /**
     *   2.4.4 - Name Is In Use
     *
     *   Name is in use.  At least one RR with a specified NAME (in the zone
     *   and class specified by the Zone Section) must exist.  Note that this
     *   prerequisite is NOT satisfied by empty nonterminals.
     *
     *   For this prerequisite, a requestor adds to the section a single RR
     *   whose NAME is equal to that of the name whose ownership of an RR is
     *   required.  RDLENGTH is zero and RDATA is therefore empty.  CLASS must
     *   be specified as ANY to differentiate this condition from that of an
     *   actual RR whose RDLENGTH is naturally zero (0) (e.g., NULL).  TYPE
     *   must be specified as ANY to differentiate this case from that of an
     *   RRset existence test.  TTL is specified as zero (0).
     *
     * @param string $name the RR name for the prerequisite
     *
     * @return boolean
     * @throws Net_DNS2_Exception
     * @access public
     *
     */
    public function checkNameInUse($name)
    {
        $this->_checkName($name);

        //
        // the Net_DNS2_RR_ANY class is just an empty stub class used for these
        // cases only
        //
        $rr = new Net_DNS2_RR_ANY;

        $rr->name       = $name;
        $rr->ttl        = 0;
        $rr->type       = 'ANY';
        $rr->class      = 'ANY';
        $rr->rdlength   = -1;
        $rr->rdata      = '';

        //
        // add the RR to the "prerequisite" section
        //
        if (!in_array($rr, $this->_packet->answer)) {
            $this->_packet->answer[] = $rr;
        }

        return true;
    }

    /**
     *   2.4.5 - Name Is Not In Use
     *
     *   Name is not in use.  No RR of any type is owned by a specified NAME.
     *   Note that this prerequisite IS satisfied by empty nonterminals.
     *
     *   For this prerequisite, a requestor adds to the section a single RR
     *   whose NAME is equal to that of the name whose nonownership of any RRs
     *   is required.  RDLENGTH is zero and RDATA is therefore empty.  CLASS
     *   must be specified as NONE.  TYPE must be specified as ANY.  TTL must
     *   be specified as zero (0).
     *
     * @param string $name the RR name for the prerequisite
     *
     * @return boolean
     * @throws Net_DNS2_Exception
     * @access public
     *
     */
    public function checkNameNotInUse($name)
    {
        $this->_checkName($name);

        //
        // the Net_DNS2_RR_ANY class is just an empty stub class used for these
        // cases only
        //
        $rr = new Net_DNS2_RR_ANY;

        $rr->name       = $name;
        $rr->ttl        = 0;
        $rr->type       = 'ANY';
        $rr->class      = 'NONE';
        $rr->rdlength   = -1;
        $rr->rdata      = '';

        //
        // add the RR to the "prerequisite" section
        //
        if (!in_array($rr, $this->_packet->answer)) {
            $this->_packet->answer[] = $rr;
        }

        return true;
    }

    /**
     * returns the current internal packet object.
     *
     * @return Net_DNS2_Packet_Request
     * @access public
     #
     */
    public function packet()
    {
        //
        // take a copy
        //
        $p = $this->_packet;

        //
        // check for an authentication method; either TSIG or SIG
        //
        if (   ($this->auth_signature instanceof Net_DNS2_RR_TSIG) 
            || ($this->auth_signature instanceof Net_DNS2_RR_SIG)
        ) {
            $p->additional[] = $this->auth_signature;
        }

        //
        // update the counts
        //
        $p->header->qdcount = count($p->question);
        $p->header->ancount = count($p->answer);
        $p->header->nscount = count($p->authority);
        $p->header->arcount = count($p->additional);

        return $p;
    }

    /**
     * executes the update request with the object informaton
     *
     * @param Net_DNS2_Packet_Response &$response ref to the response object
     *
     * @return boolean
     * @throws Net_DNS2_Exception
     * @access public
     *
     */
    public function update(&$response = null)
    {
        //
        // make sure we have some name servers set
        //
        $this->checkServers(Net_DNS2::RESOLV_CONF);

        //
        // check for an authentication method; either TSIG or SIG
        //
        if (   ($this->auth_signature instanceof Net_DNS2_RR_TSIG) 
            || ($this->auth_signature instanceof Net_DNS2_RR_SIG)
        ) {
            $this->_packet->additional[] = $this->auth_signature;
        }

        //
        // update the counts
        //
        $this->_packet->header->qdcount = count($this->_packet->question);
        $this->_packet->header->ancount = count($this->_packet->answer);
        $this->_packet->header->nscount = count($this->_packet->authority);
        $this->_packet->header->arcount = count($this->_packet->additional);

        //
        // make sure we have some data to send
        //
        if (   ($this->_packet->header->qdcount == 0) 
            || ($this->_packet->header->nscount == 0) 
        ) {
            throw new Net_DNS2_Exception(
                'empty headers- nothing to send!',
                Net_DNS2_Lookups::E_PACKET_INVALID
            );
        }

        //
        // send the packet and get back the response
        //
        $response = $this->sendPacket($this->_packet, $this->use_tcp);

        //
        // clear the internal packet so if we make another request, we don't have
        // old data being sent.
        //
        $this->_packet->reset();

        //
        // for updates, we just need to know it worked- we don't actualy need to
        // return the response object
        //
        return true;
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

<?php

/*
 * Copyright (C) 2005-2019 IP2Location.com
 * All Rights Reserved
 *
 * This library is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace IP2Location;

/**
 * IP2Location database class
 *
 */
class Database {

  /**
   * Current module's version
   *
   * @var string
   */
  const VERSION = '8.1.0';

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //  Error field constants  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  /**
   * Unsupported field message
   *
   * @var string
   */
  const FIELD_NOT_SUPPORTED = 'This parameter is unavailable in selected .BIN data file. Please upgrade.';

  /**
   * Unknown field message
   *
   * @var string
   */
  const FIELD_NOT_KNOWN = 'This parameter is inexistent. Please verify.';

  /**
   * Invalid IP address message
   *
   * @var string
   */
  const INVALID_IP_ADDRESS = 'Invalid IP address.';

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //  Field selection constants  ///////////////////////////////////////////////////////////////////////////////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  /**
   * Country code (ISO 3166-1 Alpha 2)
   *
   * @var int
   */
  const COUNTRY_CODE = 1;

  /**
   * Country name
   *
   * @var int
   */
  const COUNTRY_NAME = 2;

  /**
   * Region name
   *
   * @var int
   */
  const REGION_NAME = 3;

  /**
   * City name
   *
   * @var int
   */
  const CITY_NAME = 4;

  /**
   * Latitude
   *
   * @var int
   */
  const LATITUDE = 5;

  /**
   * Longitude
   *
   * @var int
   */
  const LONGITUDE = 6;

  /**
   * ISP name
   *
   * @var int
   */
  const ISP = 7;

  /**
   * Domain name
   *
   * @var int
   */
  const DOMAIN_NAME = 8;

  /**
   * Zip code
   *
   * @var int
   */
  const ZIP_CODE = 9;

  /**
   * Time zone
   *
   * @var int
   */
  const TIME_ZONE = 10;

  /**
   * Net speed
   *
   * @var int
   */
  const NET_SPEED = 11;

  /**
   * IDD code
   *
   * @var int
   */
  const IDD_CODE = 12;

  /**
   * Area code
   *
   * @var int
   */
  const AREA_CODE = 13;

  /**
   * Weather station code
   *
   * @var int
   */
  const WEATHER_STATION_CODE = 14;

  /**
   * Weather station name
   *
   * @var int
   */
  const WEATHER_STATION_NAME = 15;

  /**
   * Mobile Country Code
   *
   * @var int
   */
  const MCC = 16;

  /**
   * Mobile Network Code
   *
   * @var int
   */
  const MNC = 17;

  /**
   * Mobile carrier name
   *
   * @var int
   */
  const MOBILE_CARRIER_NAME = 18;

  /**
   * Elevation
   *
   * @var int
   */
  const ELEVATION = 19;

  /**
   * Usage type
   *
   * @var int
   */
  const USAGE_TYPE = 20;

  /**
   * Country name and code
   *
   * @var int
   */
  const COUNTRY = 101;

  /**
   * Latitude and Longitude
   *
   * @var int
   */
  const COORDINATES = 102;

  /**
   * IDD and area codes
   *
   * @var int
   */
  const IDD_AREA = 103;

  /**
   * Weather station name and code
   *
   * @var int
   */
  const WEATHER_STATION = 104;

  /**
   * MCC, MNC, and mobile carrier name
   *
   * @var int
   */
  const MCC_MNC_MOBILE_CARRIER_NAME = 105;

  /**
   * All fields at once
   *
   * @var int
   */
  const ALL = 1001;

  /**
   * Include the IP address of the looked up IP address
   *
   * @var int
   */
  const IP_ADDRESS = 1002;

  /**
   * Include the IP version of the looked up IP address
   *
   * @var int
   */
  const IP_VERSION = 1003;

  /**
   * Include the IP number of the looked up IP address
   *
   * @var int
   */
  const IP_NUMBER = 1004;

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //  Exception code constants  ////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  /**
   * Generic exception code
   *
   * @var int
   */
  const EXCEPTION = 10000;

  /**
   * No shmop extension found
   *
   * @var int
   */
  const EXCEPTION_NO_SHMOP = 10001;

  /**
   * Failed to open shmop memory segment for reading
   *
   * @var int
   */
  const EXCEPTION_SHMOP_READING_FAILED = 10002;

  /**
   * Failed to open shmop memory segment for writing
   *
   * @var int
   */
  const EXCEPTION_SHMOP_WRITING_FAILED = 10003;

  /**
   * Failed to create shmop memory segment
   *
   * @var int
   */
  const EXCEPTION_SHMOP_CREATE_FAILED = 10004;

  /**
   * The specified database file was not found
   *
   * @var int
   */
  const EXCEPTION_DBFILE_NOT_FOUND = 10005;

  /**
   * Not enough memory to load database file
   *
   * @var int
   */
  const EXCEPTION_NO_MEMORY = 10006;

  /**
   * No candidate databse files found
   *
   * @var int
   */
  const EXCEPTION_NO_CANDIDATES = 10007;

  /**
   * Failed to open database file
   *
   * @var int
   */
  const EXCEPTION_FILE_OPEN_FAILED = 10008;

  /**
   * Failed to determine the current path
   *
   * @var int
   */
  const EXCEPTION_NO_PATH = 10009;

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //  Caching method constants  ////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  /**
   * Directly read from the databse file
   *
   * @var int
   */
  const FILE_IO = 100001;

  /**
   * Read the whole database into a variable for caching
   *
   * @var int
   */
  const MEMORY_CACHE = 100002;

  /**
   * Use shared memory objects for caching
   *
   * @var int
   */
  const SHARED_MEMORY = 100003;

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //  Shared memory constants  /////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  /**
   * Share memory segment's permissions (for creation)
   *
   * @var int
   */
  const SHM_PERMS = 0600;

  /**
   * Number of bytes to read/write at a time in order to load the shared memory cache (512k)
   *
   * @var int
   */
  const SHM_CHUNK_SIZE = 524288;

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //  Static data  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  /**
   * Column offset mapping
   *
   * Each entry contains an array mapping databse version (0--23) to offset within a record.
   * A value of 0 means the column is not present in the given database version.
   *
   * @access private
   * @static
   * @var array
   */
  private static $columns = [
      self::COUNTRY_CODE         => [8, 8, 8, 8, 8, 8, 8, 8, 8, 8, 8, 8, 8, 8, 8, 8, 8, 8, 8, 8, 8, 8, 8, 8],
      self::COUNTRY_NAME         => [8, 8, 8, 8, 8, 8, 8, 8, 8, 8, 8, 8, 8, 8, 8, 8, 8, 8, 8, 8, 8, 8, 8, 8],
      self::REGION_NAME          => [0, 0, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12],
      self::CITY_NAME            => [0, 0, 16, 16, 16, 16, 16, 16, 16, 16, 16, 16, 16, 16, 16, 16, 16, 16, 16, 16, 16, 16, 16, 16],
      self::LATITUDE             => [0, 0, 0, 0, 20, 20, 0, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20],
      self::LONGITUDE            => [0, 0, 0, 0, 24, 24, 0, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24],
      self::ISP                  => [0, 12, 0, 20, 0, 28, 20, 28, 0, 32, 0, 36, 0, 36, 0, 36, 0, 36, 28, 36, 0, 36, 28, 36],
      self::DOMAIN_NAME          => [0, 0, 0, 0, 0, 0, 24, 32, 0, 36, 0, 40, 0, 40, 0, 40, 0, 40, 32, 40, 0, 40, 32, 40],
      self::ZIP_CODE             => [0, 0, 0, 0, 0, 0, 0, 0, 28, 28, 28, 28, 0, 28, 28, 28, 0, 28, 0, 28, 28, 28, 0, 28],
      self::TIME_ZONE            => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 32, 28, 32, 32, 32, 28, 32, 0, 32, 32, 32, 0, 32],
      self::NET_SPEED            => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 44, 0, 44, 32, 44, 0, 44, 0, 44, 0, 44],
      self::IDD_CODE             => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 36, 48, 0, 48, 0, 48, 36, 48, 0, 48],
      self::AREA_CODE            => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 40, 52, 0, 52, 0, 52, 40, 52, 0, 52],
      self::WEATHER_STATION_CODE => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 36, 56, 0, 56, 0, 56, 0, 56],
      self::WEATHER_STATION_NAME => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 40, 60, 0, 60, 0, 60, 0, 60],
      self::MCC                  => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 36, 64, 0, 64, 36, 64],
      self::MNC                  => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 40, 68, 0, 68, 40, 68],
      self::MOBILE_CARRIER_NAME  => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 44, 72, 0, 72, 44, 72],
      self::ELEVATION            => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 44, 76, 0, 76],
      self::USAGE_TYPE           => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 48, 80],
  ];

  /**
   * Column name mapping
   *
   * @access private
   * @static
   * @var array
   */
  private static $names = [
      self::COUNTRY_CODE         => 'countryCode',
      self::COUNTRY_NAME         => 'countryName',
      self::REGION_NAME          => 'regionName',
      self::CITY_NAME            => 'cityName',
      self::LATITUDE             => 'latitude',
      self::LONGITUDE            => 'longitude',
      self::ISP                  => 'isp',
      self::DOMAIN_NAME          => 'domainName',
      self::ZIP_CODE             => 'zipCode',
      self::TIME_ZONE            => 'timeZone',
      self::NET_SPEED            => 'netSpeed',
      self::IDD_CODE             => 'iddCode',
      self::AREA_CODE            => 'areaCode',
      self::WEATHER_STATION_CODE => 'weatherStationCode',
      self::WEATHER_STATION_NAME => 'weatherStationName',
      self::MCC                  => 'mcc',
      self::MNC                  => 'mnc',
      self::MOBILE_CARRIER_NAME  => 'mobileCarrierName',
      self::ELEVATION            => 'elevation',
      self::USAGE_TYPE           => 'usageType',
      self::IP_ADDRESS           => 'ipAddress',
      self::IP_VERSION           => 'ipVersion',
      self::IP_NUMBER            => 'ipNumber',
  ];

  /**
   * Database names, in order of preference for file lookup
   *
   * @var array
   */
  private static $databases = [
      // IPv4 databases
      'IP-COUNTRY-REGION-CITY-LATITUDE-LONGITUDE-ZIPCODE-TIMEZONE-ISP-DOMAIN-NETSPEED-AREACODE-WEATHER-MOBILE-ELEVATION-USAGETYPE',
      'IP-COUNTRY-REGION-CITY-LATITUDE-LONGITUDE-ISP-DOMAIN-MOBILE-USAGETYPE',
      'IP-COUNTRY-REGION-CITY-LATITUDE-LONGITUDE-ZIPCODE-TIMEZONE-ISP-DOMAIN-NETSPEED-AREACODE-WEATHER-MOBILE-ELEVATION',
      'IP-COUNTRY-REGION-CITY-LATITUDE-LONGITUDE-ZIPCODE-TIMEZONE-AREACODE-ELEVATION',
      'IP-COUNTRY-REGION-CITY-LATITUDE-LONGITUDE-ZIPCODE-TIMEZONE-ISP-DOMAIN-NETSPEED-AREACODE-WEATHER-MOBILE',
      'IP-COUNTRY-REGION-CITY-LATITUDE-LONGITUDE-ISP-DOMAIN-MOBILE',
      'IP-COUNTRY-REGION-CITY-LATITUDE-LONGITUDE-ZIPCODE-TIMEZONE-ISP-DOMAIN-NETSPEED-AREACODE-WEATHER',
      'IP-COUNTRY-REGION-CITY-LATITUDE-LONGITUDE-ZIPCODE-TIMEZONE-NETSPEED-WEATHER',
      'IP-COUNTRY-REGION-CITY-LATITUDE-LONGITUDE-ZIPCODE-TIMEZONE-ISP-DOMAIN-NETSPEED-AREACODE',
      'IP-COUNTRY-REGION-CITY-LATITUDE-LONGITUDE-ZIPCODE-TIMEZONE-AREACODE',
      'IP-COUNTRY-REGION-CITY-LATITUDE-LONGITUDE-ZIPCODE-TIMEZONE-ISP-DOMAIN-NETSPEED',
      'IP-COUNTRY-REGION-CITY-LATITUDE-LONGITUDE-TIMEZONE-NETSPEED',
      'IP-COUNTRY-REGION-CITY-LATITUDE-LONGITUDE-ZIPCODE-TIMEZONE-ISP-DOMAIN',
      'IP-COUNTRY-REGION-CITY-LATITUDE-LONGITUDE-ZIPCODE-TIMEZONE',
      'IP-COUNTRY-REGION-CITY-LATITUDE-LONGITUDE-ZIPCODE-ISP-DOMAIN',
      'IP-COUNTRY-REGION-CITY-LATITUDE-LONGITUDE-ZIPCODE',
      'IP-COUNTRY-REGION-CITY-LATITUDE-LONGITUDE-ISP-DOMAIN',
      'IP-COUNTRY-REGION-CITY-ISP-DOMAIN',
      'IP-COUNTRY-REGION-CITY-LATITUDE-LONGITUDE-ISP',
      'IP-COUNTRY-REGION-CITY-LATITUDE-LONGITUDE',
      'IP-COUNTRY-REGION-CITY-ISP',
      'IP-COUNTRY-REGION-CITY',
      'IP-COUNTRY-ISP',
      'IP-COUNTRY',
      // IPv6 databases
      'IPV6-COUNTRY-REGION-CITY-LATITUDE-LONGITUDE-ZIPCODE-TIMEZONE-ISP-DOMAIN-NETSPEED-AREACODE-WEATHER-MOBILE-ELEVATION-USAGETYPE',
      'IPV6-COUNTRY-REGION-CITY-LATITUDE-LONGITUDE-ISP-DOMAIN-MOBILE-USAGETYPE',
      'IPV6-COUNTRY-REGION-CITY-LATITUDE-LONGITUDE-ZIPCODE-TIMEZONE-ISP-DOMAIN-NETSPEED-AREACODE-WEATHER-MOBILE-ELEVATION',
      'IPV6-COUNTRY-REGION-CITY-LATITUDE-LONGITUDE-ZIPCODE-TIMEZONE-AREACODE-ELEVATION',
      'IPV6-COUNTRY-REGION-CITY-LATITUDE-LONGITUDE-ZIPCODE-TIMEZONE-ISP-DOMAIN-NETSPEED-AREACODE-WEATHER-MOBILE',
      'IPV6-COUNTRY-REGION-CITY-LATITUDE-LONGITUDE-ISP-DOMAIN-MOBILE',
      'IPV6-COUNTRY-REGION-CITY-LATITUDE-LONGITUDE-ZIPCODE-TIMEZONE-ISP-DOMAIN-NETSPEED-AREACODE-WEATHER',
      'IPV6-COUNTRY-REGION-CITY-LATITUDE-LONGITUDE-ZIPCODE-TIMEZONE-NETSPEED-WEATHER',
      'IPV6-COUNTRY-REGION-CITY-LATITUDE-LONGITUDE-ZIPCODE-TIMEZONE-ISP-DOMAIN-NETSPEED-AREACODE',
      'IPV6-COUNTRY-REGION-CITY-LATITUDE-LONGITUDE-ZIPCODE-TIMEZONE-AREACODE',
      'IPV6-COUNTRY-REGION-CITY-LATITUDE-LONGITUDE-ZIPCODE-TIMEZONE-ISP-DOMAIN-NETSPEED',
      'IPV6-COUNTRY-REGION-CITY-LATITUDE-LONGITUDE-TIMEZONE-NETSPEED',
      'IPV6-COUNTRY-REGION-CITY-LATITUDE-LONGITUDE-ZIPCODE-TIMEZONE-ISP-DOMAIN',
      'IPV6-COUNTRY-REGION-CITY-LATITUDE-LONGITUDE-ZIPCODE-TIMEZONE',
      'IPV6-COUNTRY-REGION-CITY-LATITUDE-LONGITUDE-ZIPCODE-ISP-DOMAIN',
      'IPV6-COUNTRY-REGION-CITY-LATITUDE-LONGITUDE-ZIPCODE',
      'IPV6-COUNTRY-REGION-CITY-LATITUDE-LONGITUDE-ISP-DOMAIN',
      'IPV6-COUNTRY-REGION-CITY-ISP-DOMAIN',
      'IPV6-COUNTRY-REGION-CITY-LATITUDE-LONGITUDE-ISP',
      'IPV6-COUNTRY-REGION-CITY-LATITUDE-LONGITUDE',
      'IPV6-COUNTRY-REGION-CITY-ISP',
      'IPV6-COUNTRY-REGION-CITY',
      'IPV6-COUNTRY-ISP',
      'IPV6-COUNTRY',
  ];

  /**
   * Static memory buffer to use for MEMORY_CACHE mode, the keys will be BIN filenames and the values their contents
   *
   * @access private
   * @static
   * @var array
   */
  private static $buffer = [];

  /**
   * The machine's float size
   *
   * @access private
   * @static
   * @var int
   */
  private static $floatSize = null;

  /**
   * The configured memory limit
   *
   * @access private
   * @static
   * @var int
   */
  private static $memoryLimit = null;

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //  Caching backend controls  ////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  /**
   * Caching mode to use (one of FILE_IO, MEMORY_CACHE, or SHARED_MEMORY)
   *
   * @access private
   * @var int
   */
  private $mode;

  /**
   * File pointer to use for FILE_IO mode, BIN filename for MEMORY_CACHE mode, or shared memory id to use for SHARED_MEMORY mode
   *
   * @access private
   * @var resource|int|false
   */
  private $resource = false;

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //  Database metadata  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  /**
   * Database's compilation date
   *
   * @access private
   * @var int
   */
  private $date;

  /**
   * Database's type (0--23)
   *
   * @access private
   * @var int
   */
  private $type;

  /**
   * Database's register width (as an array mapping 4 to IPv4 width, and 6 to IPv6 width)
   *
   * @access private
   * @var array
   */
  private $columnWidth = [];

  /**
   * Database's pointer offset (as an array mapping 4 to IPv4 offset, and 6 to IPv6 offset)
   *
   * @access private
   * @var array
   */
  private $offset = [];

  /**
   * Amount of IP address ranges the database contains (as an array mapping 4 to IPv4 count, and 6 to IPv6 count)
   *
   * @access private
   * @var array
   */
  private $ipCount = [];

  /**
   * Offset withing the database where IP data begins (as an array mapping 4 to IPv4 base, and 6 to IPv6 base)
   *
   * @access private
   * @var array
   */
  private $ipBase = [];


  //hjlim
  private $indexBaseAddr = [];
  private $year;
  private $month;
  private $day;
  
  // This variable will be used to hold the raw row of columns's positions
  private $raw_positions_row; 

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //  Default fields  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  /**
   * Default fields to return during lookup
   *
   * @access private
   * @var int|array
   */
  private $defaultFields = self::ALL;

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //  Administrative public interface  /////////////////////////////////////////////////////////////////////////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  /**
   * Constructor
   *
   * @access public
   * @param string $file  Filename of the BIN database to load
   * @param int $mode  Caching mode (one of FILE_IO, MEMORY_CACHE, or SHARED_MEMORY)
   * @throws \Exception
   */
  public function __construct($file = null, $mode = self::FILE_IO, $defaultFields = self::ALL) {
    // find the referred file and its size
    $rfile = self::findFile($file);
    $size  = filesize($rfile);

    // initialize caching backend
    switch ($mode) {
      case self::SHARED_MEMORY:
        // verify the shmop extension is loaded
        if (!extension_loaded('shmop')) {
          throw new \Exception(__CLASS__ . ": Please make sure your PHP setup has the 'shmop' extension enabled.", self::EXCEPTION_NO_SHMOP);
        }

        $limit = self::getMemoryLimit();
        if (false !== $limit && $size > $limit) {
          throw new \Exception(__CLASS__ . ": Insufficient memory to load file '{$rfile}'.", self::EXCEPTION_NO_MEMORY);
        }

        $this->mode = self::SHARED_MEMORY;
        $shmKey     = self::getShmKey($rfile);

        // try to open the shared memory segment
        $this->resource = @shmop_open($shmKey, 'a', 0, 0);
        if (false === $this->resource) {
          // the segment did not exist, create it and load the database into it
          $fp = fopen($rfile, 'rb');
          if (false === $fp) {
            throw new \Exception(__CLASS__ . ": Unable to open file '{$rfile}'.", self::EXCEPTION_FILE_OPEN_FAILED);
          }

          // try to open the memory segment for exclusive access
          $shmId = @shmop_open($shmKey, 'n', self::SHM_PERMS, $size);
          if (false === $shmId) {
            throw new \Exception(__CLASS__ . ": Unable to create shared memory block '{$shmKey}'.", self::EXCEPTION_SHMOP_CREATE_FAILED);
          }

          // load SHM_CHUNK_SIZE bytes at a time
          $pointer = 0;
          while ($pointer < $size) {
            $buf = fread($fp, self::SHM_CHUNK_SIZE);
            shmop_write($shmId, $buf, $pointer);
            $pointer += self::SHM_CHUNK_SIZE;
          }
          shmop_close($shmId);
          fclose($fp);

          // now open the memory segment for readonly access
          $this->resource = @shmop_open($shmKey, 'a', 0, 0);
          if (false === $this->resource) {
            throw new \Exception(__CLASS__ . ": Unable to access shared memory block '{$shmKey}' for reading.", self::EXCEPTION_SHMOP_READING_FAILED);
          }
        }
        break;

      case self::FILE_IO:
        $this->mode     = self::FILE_IO;
        $this->resource = @fopen($rfile, 'rb');
        if (false === $this->resource) {
          throw new \Exception(__CLASS__ . ": Unable to open file '{$rfile}'.", self::EXCEPTION_FILE_OPEN_FAILED);
        }
        break;

      case self::MEMORY_CACHE:
        $this->mode     = self::MEMORY_CACHE;
        $this->resource = $rfile;
        if (!array_key_exists($rfile, self::$buffer)) {
          $limit = self::getMemoryLimit();
          if (false !== $limit && $size > $limit) {
            throw new \Exception(__CLASS__ . ": Insufficient memory to load file '{$rfile}'.", self::EXCEPTION_NO_MEMORY);
          }

          self::$buffer[$rfile] = @file_get_contents($rfile);
          if (false === self::$buffer[$rfile]) {
            throw new \Exception(__CLASS__ . ": Unable to open file '{$rfile}'.", self::EXCEPTION_FILE_OPEN_FAILED);
          }
        }
        break;

      default:
    }

    // determine the platform's float size
    //
    // NB: this should be a constant instead, and some unpack / typebanging magic
    //     should be used to accomodate different float sizes, but, as the libreary
    //     is written, this is the sanest thing to do anyway
    //
    if (null === self::$floatSize) {
      self::$floatSize = strlen(pack('f', M_PI));
    }

    // set default fields to retrieve
    $this->defaultFields = $defaultFields;

    // extract database metadata
    $this->type           = $this->readByte(1) - 1;
    $this->columnWidth[4] = $this->readByte(2) * 4;
    $this->columnWidth[6] = $this->columnWidth[4] + 12;
    $this->offset[4]      = -4;
    $this->offset[6]      = 8;
    //
    $this->year                 = 2000 + $this->readByte(3);
    $this->month                = $this->readByte(4);
    $this->day                  = $this->readByte(5);
    $this->date           = date('Y-m-d', strtotime("{$this->year}-{$this->month}-{$this->day}"));
    //
    $this->ipCount[4]     = $this->readWord(6);
    $this->ipBase[4]      = $this->readWord(10);		//hjlim readword
    $this->ipCount[6]     = $this->readWord(14);
    $this->ipBase[6]      = $this->readWord(18);
	$this->indexBaseAddr[4] = $this->readWord(22);		//hjlim
	$this->indexBaseAddr[6] = $this->readWord(26);		//hjlim
  }

  /**
   * Destructor
   *
   * @access public
   */
  public function __destruct() {
    switch ($this->mode) {
      case self::FILE_IO:
        // free the file pointer
        if (false !== $this->resource) {
          fclose($this->resource);
          $this->resource = false;
        }
        break;
      case self::SHARED_MEMORY:
        // detach from the memory segment
        if (false !== $this->resource) {
          shmop_close($this->resource);
          $this->resource = false;
        }
        break;
    }
  }

  /**
   * Tear down a shared memory segment created for the given file
   *
   * @access public
   * @static
   * @param string $file  Filename of the BIN database whise segment must be deleted
   * @throws \Exception
   */
  public static function shmTeardown($file) {
    // verify the shmop extension is loaded
    if (!extension_loaded('shmop')) {
      throw new \Exception(__CLASS__ . ": Please make sure your PHP setup has the 'shmop' extension enabled.", self::EXCEPTION_NO_SHMOP);
    }

    // Get actual file path
    $rfile = realpath($file);

	// If the file cannot be found, except away
    if (false === $rfile) {
      throw new \Exception(__CLASS__ . ": Database file '{$file}' does not seem to exist.", self::EXCEPTION_DBFILE_NOT_FOUND);
    }

    $shmKey = self::getShmKey($rfile);

	// Try to open the memory segment for writing
    $shmId  = @shmop_open($shmKey, 'w', 0, 0);
    if (false === $shmId) {
      throw new \Exception(__CLASS__ . ": Unable to access shared memory block '{$shmKey}' for writing.", self::EXCEPTION_SHMOP_WRITING_FAILED);
    }

    // Delete and close the descriptor
    shmop_delete($shmId);
    shmop_close($shmId);
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //  Static tools  ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  /**
   * Get memory limit from the current PHP settings (return false if no memory limit set)
   *
   * @access private
   * @static
   * @return int|boolean
   */
  private static function getMemoryLimit() {
    // Get values if no cache
    if (null === self::$memoryLimit) {
      $limit = ini_get('memory_limit');

	  // Feal with defaults
      if ('' === (string) $limit) {
        $limit = '128M';
      }

      $value = (int) $limit;

	  // Deal with "no-limit"
      if ($value < 0) {
        $value = false;
      } else {
        // Deal with shorthand bytes
        switch (strtoupper(substr($limit, -1))) {
          case 'G': $value *= 1024;
          case 'M': $value *= 1024;
          case 'K': $value *= 1024;
        }
      }
      self::$memoryLimit = $value;
    }
    return self::$memoryLimit;
  }

  /**
   * Return the realpath of the given file or look for the first matching database option
   *
   * @param string $file  File to try to find, or null to try the databases in turn on the current file's path
   * @return string
   * @throws \Exception
   */
  private static function findFile($file = null) {
    if (null !== $file) {
      // Get actual file path
      $rfile = realpath($file);

      // If the file cannot be found, except away
      if (false === $rfile) {
        throw new \Exception(__CLASS__ . ": Database file '{$file}' does not seem to exist.", self::EXCEPTION_DBFILE_NOT_FOUND);
      }

      return $rfile;
    } else {
      // Try to get current path
      $current = realpath(dirname(__FILE__));

	  if (false === $current) {
        throw new \Exception(__CLASS__ . ": Cannot determine current path.", self::EXCEPTION_NO_PATH);
      }
      // Try each database in turn
      foreach (self::$databases as $database) {
        $rfile = realpath("{$current}/{$database}.BIN");
        if (false !== $rfile) {
          return $rfile;
        }
      }
      // No candidates found
      throw new \Exception(__CLASS__ . ": No candidate database files found.", self::EXCEPTION_NO_CANDIDATES);
    }
  }

  /**
   * Make the given number positive by wrapping it to 8 bit values
   *
   * @access private
   * @static
   * @param int $x  Number to wrap
   * @return int
   */
  private static function wrap8($x) {
    return $x + ($x < 0 ? 256 : 0);
  }

  /**
   * Make the given number positive by wrapping it to 32 bit values
   *
   * @access private
   * @static
   * @param int $x  Number to wrap
   * @return int
   */
  private static function wrap32($x) {
    return $x + ($x < 0 ? 4294967296 : 0);
  }

  /**
   * Generate a unique and repeatable shared memory key for each instance to use
   *
   * @access private
   * @static
   * @param string $filename  Filename of the BIN file
   * @return int
   */
  private static function getShmKey($filename) {
    // This will create a shared memory key that deterministically depends only on
    // the current file's path and the BIN file's path
    return (int) sprintf('%u', self::wrap32(crc32(__FILE__ . ':' . $filename)));
  }

  /**
   * Determine whether the given IP number of the given version lies between the given bounds
   *
   * This function will return 0 if the given ip number falls within the given bounds
   * for the given version, -1 if it falls below, and 1 if it falls above.
   *
   * @access private
   * @static
   * @param int $version  IP version to use (either 4 or 6)
   * @param int|string $ip  IP number to check (int for IPv4, string for IPv6)
   * @param int|string $low  Lower bound (int for IPv4, string for IPv6)
   * @param int|string $high  Uppoer bound (int for IPv4, string for IPv6)
   * @return int
   */
  private static function ipBetween($version, $ip, $low, $high) {
    if (4 === $version) {
      // Use normal PHP ints
      if ($low <= $ip) {
        if ($ip < $high) {
          return 0;
        } else {
          return 1;
        }
      } else {
        return -1;
      }
    } else {
      // Use BCMath
      if (bccomp($low, $ip, 0) <= 0) {
        if (bccomp($ip, $high, 0) <= -1) {
          return 0;
        } else {
          return 1;
        }
      } else {
        return -1;
      }
    }
  }

  /**
   * Get the IP version and number of the given IP address
   *
   * This method will return an array, whose components will be:
   * - first: 4 if the given IP address is an IPv4 one, 6 if it's an IPv6 one,
   *          or fase if it's neither.
   * - second: the IP address' number if its version is 4, the number string if
   *           its version is 6, false otherwise.
   *
   * @access private
   * @static
   * @param string $ip  IP address to extract the version and number for
   * @return array
   */
  private static function ipVersionAndNumber($ip) {
    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
      return [4, sprintf('%u', ip2long($ip))];
    } elseif (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
	  $result = 0;

	  foreach (str_split(bin2hex(inet_pton($ip)), 8) as $word) {
        $result = bcadd(bcmul($result, '4294967296', 0), self::wrap32(hexdec($word)), 0);
      }

	  return [6, $result];
    } else {
      // Invalid IP address, return falses
      return [false, false];
    }
  }

  /**
   * Return the decimal string representing the binary data given
   *
   * @access private
   * @static
   * @param string $data  Binary data to parse
   * @return string
   */
  private static function bcBin2Dec($data) {
	$parts = array(
		unpack('V', substr($data, 12, 4)),
		unpack('V', substr($data, 8, 4)),
		unpack('V', substr($data, 4, 4)),
		unpack('V', substr($data, 0, 4)),
	);

	foreach($parts as &$part)
		if($part[1] < 0)
			$part[1] += 4294967296;

	$result = bcadd(bcadd(bcmul($parts[0][1], bcpow(4294967296, 3)), bcmul($parts[1][1], bcpow(4294967296, 2))), bcadd(bcmul($parts[2][1], 4294967296), $parts[3][1]));

    return $result;
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //  Caching backend abstraction  /////////////////////////////////////////////////////////////////////////////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  /**
   * Low level read function to abstract away the caching mode being used
   *
   * @access private
   * @param int $pos  Position from where to start reading
   * @param int $len  Read this many bytes
   * @return string
   */
  private function read($pos, $len) {
    switch ($this->mode) {
      case self::SHARED_MEMORY:
        return shmop_read($this->resource, $pos, $len);

      case self::MEMORY_CACHE:
        return $data = substr(self::$buffer[$this->resource], $pos, $len);

      default:
        fseek($this->resource, $pos, SEEK_SET);
        return fread($this->resource, $len);
    }
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //  Low-level read functions  ////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  /**
   * Low level function to fetch a string from the caching backend
   *
   * @access private
   * @param int $pos  Position to read from
   * @param int $additional  Additional offset to apply
   * @return string
   */
  private function readString($pos, $additional = 0) {
	 
	// Get the actual pointer to the string's head by extract from the raw row
	$spos = unpack('V', substr($this->raw_positions_row, $pos, 4))[1] + $additional;
	 
	// Read as much as the length (first "string" byte) indicates
	return $this->read($spos + 1, $this->readByte($spos + 1));
	 
  }

  /**
   * Low level function to fetch a float from the caching backend
   *
   * @access private
   * @param int $pos  Position to read from
   * @return float
   */
  private function readFloat($pos) {
    // Unpack a float's size worth of data
    return unpack('f', substr($this->raw_positions_row, $pos, self::$floatSize))[1];
  }

  /**
   * Low level function to fetch a quadword (128 bits) from the caching backend
   *
   * @access private
   * @param int $pos  Position to read from
   * @return string
   */
  private function readQuad($pos) {
    // Use BCMath ints to get a quad's (128-bit) value
    return self::bcBin2Dec($this->read($pos - 1, 16));
  }

  /**
   * Low level function to fetch a word (32 bits) from the caching backend
   *
   * @access private
   * @param int $pos  Position to read from
   * @return int
   */
  private function readWord($pos) {
    // Unpack a long's worth of data
    return self::wrap32(unpack('V', $this->read($pos - 1, 4))[1]);
  }

  /**
   * Low level function to fetch a byte from the caching backend
   *
   * @access private
   * @param int $pos  Position to read from
   * @return string
   */
  private function readByte($pos) {
    // Unpack a byte's worth of data
    return self::wrap8(unpack('C', $this->read($pos - 1, 1))[1]);
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //  High-level read functions  ///////////////////////////////////////////////////////////////////////////////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  /**
   * High level function to fetch the country name and code
   *
   * @access private
   * @param int|boolean $pointer  Position to read from, if false, return self::INVALID_IP_ADDRESS
   * @return array
   */
  private function readCountryNameAndCode($pointer) {
    if (false === $pointer) {
      // Deal with invalid IPs
      $countryCode = self::INVALID_IP_ADDRESS;
      $countryName = self::INVALID_IP_ADDRESS;
    } elseif (0 === self::$columns[self::COUNTRY_CODE][$this->type]) {
      // If the field is not suported, return accordingly
      $countryCode = self::FIELD_NOT_SUPPORTED;
      $countryName = self::FIELD_NOT_SUPPORTED;
    } else {
      // Read the country code and name (the name shares the country's pointer,
      // but it must be artificially displaced 3 bytes ahead: 2 for the country code, one
      // for the country name's length)
      $countryCode = $this->readString(self::$columns[self::COUNTRY_CODE][$this->type]);
      $countryName = $this->readString(self::$columns[self::COUNTRY_NAME][$this->type], 3);
    }

    return [$countryName, $countryCode];
  }

  /**
   * High level function to fetch the region name
   *
   * @access private
   * @param int $pointer  Position to read from, if false, return self::INVALID_IP_ADDRESS
   * @return string
   */
  private function readRegionName($pointer) {
    if (false === $pointer) {
      // Deal with invalid IPs
      $regionName = self::INVALID_IP_ADDRESS;
    } elseif (0 === self::$columns[self::REGION_NAME][$this->type]) {
      // If the field is not suported, return accordingly
      $regionName = self::FIELD_NOT_SUPPORTED;
    } else {
      // Read the region name
      $regionName = $this->readString(self::$columns[self::REGION_NAME][$this->type]);
    }
    return $regionName;
  }

  /**
   * High level function to fetch the city name
   *
   * @access private
   * @param int $pointer  Position to read from, if false, return self::INVALID_IP_ADDRESS
   * @return string
   */
  private function readCityName($pointer) {
    if (false === $pointer) {
      // Deal with invalid IPs
      $cityName = self::INVALID_IP_ADDRESS;
    } elseif (0 === self::$columns[self::CITY_NAME][$this->type]) {
      // If the field is not suported, return accordingly
      $cityName = self::FIELD_NOT_SUPPORTED;
    } else {
      // Read the city name
      $cityName = $this->readString(self::$columns[self::CITY_NAME][$this->type]);
    }
    return $cityName;
  }

  /**
   * High level function to fetch the latitude and longitude
   *
   * @access private
   * @param int $pointer  Position to read from, if false, return self::INVALID_IP_ADDRESS
   * @return array
   */
  private function readLatitudeAndLongitude($pointer) {
    if (false === $pointer) {
      // Deal with invalid IPs
      $latitude  = self::INVALID_IP_ADDRESS;
      $longitude = self::INVALID_IP_ADDRESS;
    } elseif (0 === self::$columns[self::LATITUDE][$this->type]) {
      // If the field is not suported, return accordingly
      $latitude  = self::FIELD_NOT_SUPPORTED;
      $longitude = self::FIELD_NOT_SUPPORTED;
    } else {
      // Read latitude and longitude
      $latitude  = round($this->readFloat(self::$columns[self::LATITUDE][$this->type]), 6);
      $longitude = round($this->readFloat(self::$columns[self::LONGITUDE][$this->type]), 6);
    }
    return [$latitude, $longitude];
  }

  /**
   * High level function to fetch the ISP name
   *
   * @access private
   * @param int $pointer  Position to read from, if false, return self::INVALID_IP_ADDRESS
   * @return string
   */
  private function readIsp($pointer) {
    if (false === $pointer) {
      // Deal with invalid IPs
      $isp = self::INVALID_IP_ADDRESS;
    } elseif (0 === self::$columns[self::ISP][$this->type]) {
      // If the field is not suported, return accordingly
      $isp = self::FIELD_NOT_SUPPORTED;
    } else {
      // Read isp name
      $isp = $this->readString(self::$columns[self::ISP][$this->type]);
    }
    return $isp;
  }

  /**
   * High level function to fetch the domain name
   *
   * @access private
   * @param int $pointer  Position to read from, if false, return self::INVALID_IP_ADDRESS
   * @return string
   */
  private function readDomainName($pointer) {
    if (false === $pointer) {
      // Deal with invalid IPs
      $domainName = self::INVALID_IP_ADDRESS;
    } elseif (0 === self::$columns[self::DOMAIN_NAME][$this->type]) {
      // If the field is not suported, return accordingly
      $domainName = self::FIELD_NOT_SUPPORTED;
    } else {
      // Read the domain name
      $domainName = $this->readString(self::$columns[self::DOMAIN_NAME][$this->type]);
    }
    return $domainName;
  }

  /**
   * High level function to fetch the zip code
   *
   * @access private
   * @param int $pointer  Position to read from, if false, return self::INVALID_IP_ADDRESS
   * @return string
   */
  private function readZipCode($pointer) {
    if (false === $pointer) {
      // Deal with invalid IPs
      $zipCode = self::INVALID_IP_ADDRESS;
    } elseif (0 === self::$columns[self::ZIP_CODE][$this->type]) {
      // If the field is not suported, return accordingly
      $zipCode = self::FIELD_NOT_SUPPORTED;
    } else {
      // Read the zip code
      $zipCode = $this->readString(self::$columns[self::ZIP_CODE][$this->type]);
    }
    return $zipCode;
  }

  /**
   * High level function to fetch the time zone
   *
   * @access private
   * @param int $pointer  Position to read from, if false, return self::INVALID_IP_ADDRESS
   * @return string
   */
  private function readTimeZone($pointer) {
    if (false === $pointer) {
      // Deal with invalid IPs
      $timeZone = self::INVALID_IP_ADDRESS;
    } elseif (0 === self::$columns[self::TIME_ZONE][$this->type]) {
      // If the field is not suported, return accordingly
      $timeZone = self::FIELD_NOT_SUPPORTED;
    } else {
      // Read the time zone
      $timeZone = $this->readString(self::$columns[self::TIME_ZONE][$this->type]);
    }
    return $timeZone;
  }

  /**
   * High level function to fetch the net speed
   *
   * @access private
   * @param int $pointer  Position to read from, if false, return self::INVALID_IP_ADDRESS
   * @return string
   */
  private function readNetSpeed($pointer) {
    if (false === $pointer) {
      // Deal with invalid IPs
      $netSpeed = self::INVALID_IP_ADDRESS;
    } elseif (0 === self::$columns[self::NET_SPEED][$this->type]) {
      // If the field is not suported, return accordingly
      $netSpeed = self::FIELD_NOT_SUPPORTED;
    } else {
      // Read the net speed
      $netSpeed = $this->readString(self::$columns[self::NET_SPEED][$this->type]);
    }
    return $netSpeed;
  }

  /**
   * High level function to fetch the IDD and area codes
   *
   * @access private
   * @param int $pointer  Position to read from, if false, return self::INVALID_IP_ADDRESS
   * @return array
   */
  private function readIddAndAreaCodes($pointer) {
    if (false === $pointer) {
      // Deal with invalid IPs
      $iddCode  = self::INVALID_IP_ADDRESS;
      $areaCode = self::INVALID_IP_ADDRESS;
    } elseif (0 === self::$columns[self::IDD_CODE][$this->type]) {
      // If the field is not suported, return accordingly
      $iddCode  = self::FIELD_NOT_SUPPORTED;
      $areaCode = self::FIELD_NOT_SUPPORTED;
    } else {
      // Read IDD and area codes
      $iddCode  = $this->readString(self::$columns[self::IDD_CODE][$this->type]);
      $areaCode = $this->readString(self::$columns[self::AREA_CODE][$this->type]);
    }
    return [$iddCode, $areaCode];
  }

  /**
   * High level function to fetch the weather station name and code
   *
   * @access private
   * @param int $pointer  Position to read from, if false, return self::INVALID_IP_ADDRESS
   * @return array
   */
  private function readWeatherStationNameAndCode($pointer) {
    if (false === $pointer) {
      // Deal with invalid IPs
      $weatherStationName = self::INVALID_IP_ADDRESS;
      $weatherStationCode = self::INVALID_IP_ADDRESS;
    } elseif (0 === self::$columns[self::WEATHER_STATION_NAME][$this->type]) {
      // If the field is not suported, return accordingly
      $weatherStationName = self::FIELD_NOT_SUPPORTED;
      $weatherStationCode = self::FIELD_NOT_SUPPORTED;
    } else {
      // Read weather station name and code
      $weatherStationName = $this->readString(self::$columns[self::WEATHER_STATION_NAME][$this->type]);
      $weatherStationCode = $this->readString(self::$columns[self::WEATHER_STATION_CODE][$this->type]);
    }
    return [$weatherStationName, $weatherStationCode];
  }

  /**
   * High level function to fetch the MCC, MNC, and mobile carrier name
   *
   * @access private
   * @param int $pointer  Position to read from, if false, return self::INVALID_IP_ADDRESS
   * @return array
   */
  private function readMccMncAndMobileCarrierName($pointer) {
    if (false === $pointer) {
      // Deal with invalid IPs
      $mcc               = self::INVALID_IP_ADDRESS;
      $mnc               = self::INVALID_IP_ADDRESS;
      $mobileCarrierName = self::INVALID_IP_ADDRESS;
    } elseif (0 === self::$columns[self::MCC][$this->type]) {
      // If the field is not suported, return accordingly
      $mcc               = self::FIELD_NOT_SUPPORTED;
      $mnc               = self::FIELD_NOT_SUPPORTED;
      $mobileCarrierName = self::FIELD_NOT_SUPPORTED;
    } else {
      // Read MCC, MNC, and mobile carrier name
      $mcc               = $this->readString(self::$columns[self::MCC][$this->type]);
      $mnc               = $this->readString(self::$columns[self::MNC][$this->type]);
      $mobileCarrierName = $this->readString(self::$columns[self::MOBILE_CARRIER_NAME][$this->type]);
    }
    return [$mcc, $mnc, $mobileCarrierName];
  }

  /**
   * High level function to fetch the elevation
   *
   * @access private
   * @param int $pointer  Position to read from, if false, return self::INVALID_IP_ADDRESS
   * @return string
   */
  private function readElevation($pointer) {
    if (false === $pointer) {
      // Deal with invalid IPs
      $elevation = self::INVALID_IP_ADDRESS;
    } elseif (0 === self::$columns[self::ELEVATION][$this->type]) {
      // If the field is not suported, return accordingly
      $elevation = self::FIELD_NOT_SUPPORTED;
    } else {
      // Read the elevation
      $elevation = $this->readString(self::$columns[self::ELEVATION][$this->type]);
    }
    return $elevation;
  }

  /**
   * High level function to fetch the usage type
   *
   * @access private
   * @param int $pointer  Position to read from, if false, return self::INVALID_IP_ADDRESS
   * @return string
   */
  private function readUsageType($pointer) {
    if (false === $pointer) {
      // Deal with invalid IPs
      $usageType = self::INVALID_IP_ADDRESS;
    } elseif (0 === self::$columns[self::USAGE_TYPE][$this->type]) {
      // If the field is not suported, return accordingly
      $usageType = self::FIELD_NOT_SUPPORTED;
    } else {
      $usageType = $this->readString(self::$columns[self::USAGE_TYPE][$this->type]);
    }
    return $usageType;
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //  Binary search and support functions  /////////////////////////////////////////////////////////////////////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  /**
   * High level fucntion to read an IP address of the given version
   *
   * @access private
   * @param int $version  IP version to read (either 4 or 6, returns false on anything else)
   * @param int $pos  Position to read from
   * @return int|string|boolean
   */
  private function readIp($version, $pos) {
    if (4 === $version) {
      // Read a standard PHP int
      return self::wrap32($this->readWord($pos));
    } elseif (6 === $version) {
      // Read as BCMath int (quad)
      return $this->readQuad($pos);
    } else {
      // unrecognized
      return false;
    }
  }

  /**
   * Perform a binary search on the given IP number and return a pointer to its record
   *
   * @access private
   * @param int $version  IP version to use for searching
   * @param int $ipNumber  IP number to look for
   * @return int|boolean
   */
  private function binSearch($version, $ipNumber, $cidr=false) {
    if (false === $version) {
      // unrecognized version
      return false;
    }

    // initialize fields
    $base   = $this->ipBase[$version];
    $offset = $this->offset[$version];
    $width  = $this->columnWidth[$version];
    $high   = $this->ipCount[$version];
    $low    = 0;

	//hjlim
	$indexBaseStart = $this->indexBaseAddr[$version];
	if ($indexBaseStart > 0){
		$indexPos = 0;
		switch($version){
			case 4:
				$ipNum1_2 = intval($ipNumber / 65536);
				$indexPos = $indexBaseStart + ($ipNum1_2 << 3);

				break;

			case 6:
				$ipNum1 = intval(bcdiv($ipNumber, bcpow('2', '112')));
				$indexPos = $indexBaseStart + ($ipNum1 << 3);

				break;

			default:
				return false;
		}

		$low = $this->readWord($indexPos);
		$high = $this->readWord($indexPos + 4);
	}

    // as long as we can narrow down the search...
	while ($low <= $high) {
      $mid     = (int) ($low + (($high - $low) >> 1));

	  // Read IP ranges to get boundaries
      $ip_from = $this->readIp($version, $base + $width * $mid);
      $ip_to   = $this->readIp($version, $base + $width * ($mid + 1));

      // determine whether to return, repeat on the lower half, or repeat on the upper half
      switch (self::ipBetween($version, $ipNumber, $ip_from, $ip_to)) {
        case 0:
          return ($cidr) ? array($ip_from, $ip_to) : $base + $offset + $mid * $width;
        case -1:
          $high = $mid - 1;
          break;
        case 1:
          $low  = $mid + 1;
          break;
      }
    }

    // nothing found
    return false;
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //  Public interface  ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  /**
   * Get the database's compilation date as a string of the form 'YYYY-MM-DD'
   *
   * @access public
   * @return string
   */
  public function getDate() {
    return $this->date;
  }

  /**
   * Get the database's type (1--24)
   *
   * @access public
   * @return int
   */
  public function getType() {
    return $this->type + 1;
  }

  /**
   * Return this database's available fields
   *
   * @access public
   * @param boolean $asNames  Whether to return the mapped names intead of numbered constants
   * @return array
   */
  public function getFields($asNames = false) {
    $result = array_keys(array_filter(self::$columns, function ($field) {
              return 0 !== $field[$this->type];
            }));
    if ($asNames) {
      $return = [];
      foreach ($result as $field) {
        $return[] = self::$names[$field];
      }
      return $return;
    } else {
      return $result;
    }
  }

  /**
   * Return the version of module
   */
  public function getModuleVersion() {
	return self::VERSION;
  }

  /**
   * Return the version of module
   */
  public function getDatabaseVersion() {
	return $this->year . '.' . $this->month . '.' . $this->day;
  }

  /**
   * This function will look the given IP address up in the database and return the result(s) asked for
   *
   * If a single, SINGULAR, field is specified, only its mapped value is returned.
   * If many fields are given (as an array) or a MULTIPLE field is specified, an
   * array whith the returned singular field names as keys and their corresponding
   * values is returned.
   *
   * @access public
   * @param string $ip  IP address to look up
   * @param int|array $fields  Field(s) to return
   * @param boolean $asNamed  Whether to return an associative array instead
   * @return mixed|array|boolean
   */
  public function lookup($ip, $fields = null, $asNamed = true) {

    // extract IP version and number
    list($ipVersion, $ipNumber) = self::ipVersionAndNumber($ip);
    // perform the binary search proper (if the IP address was invalid, binSearch will return false)
    $pointer = $this->binSearch($ipVersion, $ipNumber);
    if(empty($pointer)) { return false; }

    // apply defaults if needed
    if (null === $fields) {
      $fields = $this->defaultFields;
    }

    // Get the entire row based on the pointer value
    // The length of the row differs based on the IP version
    if (4 === $ipVersion) {
      $this->raw_positions_row = $this->read($pointer - 1, $this->columnWidth[4] + 4);
    } elseif (6 === $ipVersion) {
      $this->raw_positions_row = $this->read($pointer - 1, $this->columnWidth[6]);
    }

    // turn fields into an array in case it wasn't already
    $ifields = (array) $fields;
	
	// add fields if needed
    if (in_array(self::ALL, $ifields)) {
	
      $ifields[] = self::REGION_NAME;
      $ifields[] = self::CITY_NAME;
      $ifields[] = self::ISP;
      $ifields[] = self::DOMAIN_NAME;
      $ifields[] = self::ZIP_CODE;
      $ifields[] = self::TIME_ZONE;
      $ifields[] = self::NET_SPEED;
      $ifields[] = self::ELEVATION;
      $ifields[] = self::USAGE_TYPE;
      //
      $ifields[] = self::COUNTRY;
      $ifields[] = self::COORDINATES;
      $ifields[] = self::IDD_AREA;
      $ifields[] = self::WEATHER_STATION;
      $ifields[] = self::MCC_MNC_MOBILE_CARRIER_NAME;
      //
      $ifields[] = self::IP_ADDRESS;
      $ifields[] = self::IP_VERSION;
      $ifields[] = self::IP_NUMBER;
	  

    }
    // turn into a uniquely-valued array the fast way
    // (see: http://php.net/manual/en/function.array-unique.php#77743)
    $afields = array_keys(array_flip($ifields));
    // sorting them in reverse order warrants that by the time we get to
    // SINGULAR fields, its MULTIPLE counterparts, if at all present, have
    // already been retrieved
    rsort($afields);

    // maintain a list of already retrieved fields to avoid doing it twice
    $done    = [
        self::COUNTRY_CODE                => false,
        self::COUNTRY_NAME                => false,
        self::REGION_NAME                 => false,
        self::CITY_NAME                   => false,
        self::LATITUDE                    => false,
        self::LONGITUDE                   => false,
        self::ISP                         => false,
        self::DOMAIN_NAME                 => false,
        self::ZIP_CODE                    => false,
        self::TIME_ZONE                   => false,
        self::NET_SPEED                   => false,
        self::IDD_CODE                    => false,
        self::AREA_CODE                   => false,
        self::WEATHER_STATION_CODE        => false,
        self::WEATHER_STATION_NAME        => false,
        self::MCC                         => false,
        self::MNC                         => false,
        self::MOBILE_CARRIER_NAME         => false,
        self::ELEVATION                   => false,
        self::USAGE_TYPE                  => false,
        //
        self::COUNTRY                     => false,
        self::COORDINATES                 => false,
        self::IDD_AREA                    => false,
        self::WEATHER_STATION             => false,
        self::MCC_MNC_MOBILE_CARRIER_NAME => false,
        //
        self::IP_ADDRESS                  => false,
        self::IP_VERSION                  => false,
        self::IP_NUMBER                   => false,
    ];
    // results are empty to begin with
    $results = [];

    // treat each field in turn
    foreach ($afields as $afield) {
      switch ($afield) {
        // purposefully ignore self::ALL, we already dealt with it
        case self::ALL: break;
        //
        case self::COUNTRY:
          if (!$done[self::COUNTRY]) {
            list($results[self::COUNTRY_NAME], $results[self::COUNTRY_CODE]) = $this->readCountryNameAndCode($pointer);
            $done[self::COUNTRY]      = true;
            $done[self::COUNTRY_CODE] = true;
            $done[self::COUNTRY_NAME] = true;
          }
          break;
        case self::COORDINATES:
          if (!$done[self::COORDINATES]) {
            list($results[self::LATITUDE], $results[self::LONGITUDE]) = $this->readLatitudeAndLongitude($pointer);
            $done[self::COORDINATES] = true;
            $done[self::LATITUDE]    = true;
            $done[self::LONGITUDE]   = true;
          }
          break;
        case self::IDD_AREA:
          if (!$done[self::IDD_AREA]) {
            list($results[self::IDD_CODE], $results[self::AREA_CODE]) = $this->readIddAndAreaCodes($pointer);
            $done[self::IDD_AREA]  = true;
            $done[self::IDD_CODE]  = true;
            $done[self::AREA_CODE] = true;
          }
          break;
        case self::WEATHER_STATION:
          if (!$done[self::WEATHER_STATION]) {
            list($results[self::WEATHER_STATION_NAME], $results[self::WEATHER_STATION_CODE]) = $this->readWeatherStationNameAndCode($pointer);
            $done[self::WEATHER_STATION]      = true;
            $done[self::WEATHER_STATION_NAME] = true;
            $done[self::WEATHER_STATION_CODE] = true;
          }
          break;
        case self::MCC_MNC_MOBILE_CARRIER_NAME:
          if (!$done[self::MCC_MNC_MOBILE_CARRIER_NAME]) {
            list($results[self::MCC], $results[self::MNC], $results[self::MOBILE_CARRIER_NAME]) = $this->readMccMncAndMobileCarrierName($pointer);
            $done[self::MCC_MNC_MOBILE_CARRIER_NAME] = true;
            $done[self::MCC]                         = true;
            $done[self::MNC]                         = true;
            $done[self::MOBILE_CARRIER_NAME]         = true;
          }
          break;
        //
        case self::COUNTRY_CODE:
          if (!$done[self::COUNTRY_CODE]) {
            $results[self::COUNTRY_CODE] = $this->readCountryNameAndCode($pointer)[1];
            $done[self::COUNTRY_CODE]    = true;
          }
          break;
        case self::COUNTRY_NAME:
          if (!$done[self::COUNTRY_NAME]) {
            $results[self::COUNTRY_NAME] = $this->readCountryNameAndCode($pointer)[0];
            $done[self::COUNTRY_NAME]    = true;
          }
          break;
        case self::REGION_NAME:
          if (!$done[self::REGION_NAME]) {
            $results[self::REGION_NAME] = $this->readRegionName($pointer);
            $done[self::REGION_NAME]    = true;
          }
          break;
        case self::CITY_NAME:
          if (!$done[self::CITY_NAME]) {
            $results[self::CITY_NAME] = $this->readCityName($pointer);
            $done[self::CITY_NAME]    = true;
          }
          break;
        case self::LATITUDE:
          if (!$done[self::LATITUDE]) {
            $results[self::LATITUDE] = $this->readLatitudeAndLongitude($pointer)[0];
            $done[self::LATITUDE]    = true;
          }
          break;
        case self::LONGITUDE:
          if (!$done[self::LONGITUDE]) {
            $results[self::LONGITUDE] = $this->readLatitudeAndLongitude($pointer)[1];
            $done[self::LONGITUDE]    = true;
          }
          break;
        case self::ISP:
          if (!$done[self::ISP]) {
            $results[self::ISP] = $this->readIsp($pointer);
            $done[self::ISP]    = true;
          }
          break;
        case self::DOMAIN_NAME:
          if (!$done[self::DOMAIN_NAME]) {
            $results[self::DOMAIN_NAME] = $this->readDomainName($pointer);
            $done[self::DOMAIN_NAME]    = true;
          }
          break;
        case self::ZIP_CODE:
          if (!$done[self::ZIP_CODE]) {
            $results[self::ZIP_CODE] = $this->readZipCode($pointer);
            $done[self::ZIP_CODE]    = true;
          }
          break;
        case self::TIME_ZONE:
          if (!$done[self::TIME_ZONE]) {
            $results[self::TIME_ZONE] = $this->readTimeZone($pointer);
            $done[self::TIME_ZONE]    = true;
          }
          break;
        case self::NET_SPEED:
          if (!$done[self::NET_SPEED]) {
            $results[self::NET_SPEED] = $this->readNetSpeed($pointer);
            $done[self::NET_SPEED]    = true;
          }
          break;
        case self::IDD_CODE:
          if (!$done[self::IDD_CODE]) {
            $results[self::IDD_CODE] = $this->readIddAndAreaCodes($pointer)[0];
            $done[self::IDD_CODE]    = true;
          }
          break;
        case self::AREA_CODE:
          if (!$done[self::AREA_CODE]) {
            $results[self::AREA_CODE] = $this->readIddAndAreaCodes($pointer)[1];
            $done[self::AREA_CODE]    = true;
          }
          break;
        case self::WEATHER_STATION_CODE:
          if (!$done[self::WEATHER_STATION_CODE]) {
            $results[self::WEATHER_STATION_CODE] = $this->readWeatherStationNameAndCode($pointer)[1];
            $done[self::WEATHER_STATION_CODE]    = true;
          }
          break;
        case self::WEATHER_STATION_NAME:
          if (!$done[self::WEATHER_STATION_NAME]) {
            $results[self::WEATHER_STATION_NAME] = $this->readWeatherStationNameAndCode($pointer)[0];
            $done[self::WEATHER_STATION_NAME]    = true;
          }
          break;
        case self::MCC:
          if (!$done[self::MCC]) {
            $results[self::MCC] = $this->readMccMncAndMobileCarrierName($pointer)[0];
            $done[self::MCC]    = true;
          }
          break;
        case self::MNC:
          if (!$done[self::MNC]) {
            $results[self::MNC] = $this->readMccMncAndMobileCarrierName($pointer)[1];
            $done[self::MNC]    = true;
          }
          break;
        case self::MOBILE_CARRIER_NAME:
          if (!$done[self::MOBILE_CARRIER_NAME]) {
            $results[self::MOBILE_CARRIER_NAME] = $this->readMccMncAndMobileCarrierName($pointer)[2];
            $done[self::MOBILE_CARRIER_NAME]    = true;
          }
          break;
        case self::ELEVATION:
          if (!$done[self::ELEVATION]) {
            $results[self::ELEVATION] = $this->readElevation($pointer);
            $done[self::ELEVATION]    = true;
          }
          break;
        case self::USAGE_TYPE:
          if (!$done[self::USAGE_TYPE]) {
            $results[self::USAGE_TYPE] = $this->readUsageType($pointer);
            $done[self::USAGE_TYPE]    = true;
          }
          break;
        //
        case self::IP_ADDRESS:
          if (!$done[self::IP_ADDRESS]) {
            $results[self::IP_ADDRESS] = $ip;
            $done[self::IP_ADDRESS]    = true;
          }
          break;
        case self::IP_VERSION:
          if (!$done[self::IP_VERSION]) {
            $results[self::IP_VERSION] = $ipVersion;
            $done[self::IP_VERSION]    = true;
          }
          break;
        case self::IP_NUMBER:
          if (!$done[self::IP_NUMBER]) {
            $results[self::IP_NUMBER] = $ipNumber;
            $done[self::IP_NUMBER]    = true;
          }
          break;
        //
        default:
          $results[$afield] = self::FIELD_NOT_KNOWN;
      }
    }

    // If we were asked for an array, or we have multiple results to return...
    if (is_array($fields) || count($results) > 1) {
      // return array
      if ($asNamed) {
        // apply translations if needed
        $return = [];
        foreach ($results as $key => $val) {
          if (array_key_exists($key, static::$names)) {
            $return[static::$names[$key]] = $val;
          } else {
            $return[$key] = $val;
          }
        }
        return $return;
      } else {
        return $results;
      }
    } else {
      // return a single value
      return array_values($results)[0];
    }
  }

  /**
   * For a given IP address, returns the cidr of his sub-network.
   *
   * For example, calling get_cidr('91.200.12.233') returns '91.200.0.0/13'.
   * Useful to setup "Deny From 91.200.0.0/13" in .htaccess file for Apache2
   * server against spam.
   * */
  public function get_cidr($ip) {
    // extract IP version and number
    list($ipVersion, $ipNumber) = self::ipVersionAndNumber($ip);
    // perform the binary search proper (if the IP address was invalid, binSearch will return false)
    $resp = $this->binSearch($ipVersion, $ipNumber, true);
    if(!empty($resp)) {
      list($ip_from, $ip_to) = $resp;
      $i=32; $mask=1;
      while(($ip_to & $mask) == 0) {
        $mask *= 2; $i--;
      }
      $ip = long2ip($ip_from);
      return "$ip/$i";
    }
    return false;
  }

}

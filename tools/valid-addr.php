<?php

//http://download.ip2location.com/lite/IP2LOCATION-LITE-DB1.BIN.ZIP

require_once './IP2Location.php';
require_once './Net/DNS2.php';


$db = new \IP2Location\Database('./databases/IP2LOCATION-LITE-DB1.BIN', \IP2Location\Database::FILE_IO);
$r = new Net_DNS2_Resolver(array('nameservers' => array('223.5.5.5', '223.6.6.6')));

$src_fp = fopen('../adblock-for-dnsmasq.conf', 'r');

while(!feof($src_fp)){
  $row = fgets($src_fp, 512);
  if(empty($row)){
    continue;
  }

  if(preg_match('/^address=\/(.+)?\/$/', $row, $matchs)){
    try{
      $result = $r->query($matchs[1], 'A');
      $result = $result->answer;

      if(is_array($result) && count($result) > 0){

        //find the A record
        $a_record = null;
        foreach($result as $res){
          if($res->type == 'A'){
            $a_record = $res;
            break;
          }
        }

        if(!$a_record){
          echo '未找到A记录: ', $matchs[1], "\n";
          continue;
        }
        $records = $db->lookup($a_record->address, \IP2Location\Database::ALL);
        echo $a_record->address,"\t", $matchs[1],"\t",$records['countryCode'], "\t", $records['countryName'] ,"\n";
      }else{
        echo '记录为空: ', $matchs[1], "\n";
      }
    }catch(Net_DNS2_Exception $e){
      //@TODO code=3的时候再试一次
      echo "failed: ", $matchs[1],"\t", $e->getMessage(),"\t", $e->getCode(), "\n";
    }
  }
}

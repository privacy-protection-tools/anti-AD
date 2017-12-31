<?php

$a = array('uu'=>array('xx' => 1, 'yy' => 2),'pp' => 123, 'zz' => 0);
$b = array('cc' => array('xx' => 78989, 'yy' => 99), 'uu' => array('zz' => 989), 'pp' => 65);

var_dump(array_merge_recursive($a, $b));
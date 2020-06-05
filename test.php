<?php
$array[0]['name'] = 1;
$array[0]['cash'] = 2;
$array[] = array('name' => 1, 'cash' => 2);
echo '<pre>';
print_r($array);
$a = serialize($array);
echo $a;
$a = unserialize($a);
print_r($a);

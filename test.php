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
Array ( 
    [0] => Array ( [CID] => 1 [name] => 產品1 [CCash] => 10 [count] => 1 ) 
    [2] => Array ( [CID] => 3 [name] => 產品3 [CCash] => 30 [count] => 1 ) )
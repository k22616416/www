<?php
$array[0]['name'] = 1;
$array[1] = array('name2', 2);
$array[] = array('name3', 3);
echo '<pre>';
print_r($array);
print_r(serialize($array));

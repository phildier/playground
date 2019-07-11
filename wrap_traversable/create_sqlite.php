<?php

require_once 'db.php';

$create_table = <<<EOF
CREATE TABLE test_fixture (id INT, data1 CHAR(255), data2 CHAR(255));
EOF;

$pdo->exec($create_table);

$id=0;
while($id++<10000) {
	$data1 = str_repeat(md5(rand(0,100)),8);
	$data2 = str_repeat(md5(rand(100,200)),8);
	$pdo->exec("INSERT INTO test_fixture (id, data1, data2) VALUES ('$id','$data1','$data2')");
}

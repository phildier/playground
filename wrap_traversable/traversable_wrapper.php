<?php

require_once 'db.php';

printf("memory before: %smb\n", round(memory_get_usage()/1024/1024,2));

$statement_handle = $pdo->query("SELECT * FROM test_fixture");
$wrapper = new TransformWrapper($statement_handle);

$idx = 0;
foreach($wrapper as $r) {
	if($idx++ > 10) break;
	printf("%s %s %s\n",$r['id'], substr($r['data1'],0,10), substr($r['data2'],0,10));
}

printf("memory after echo: %smb\n", round(memory_get_usage()/1024/1024,2));

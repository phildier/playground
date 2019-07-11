<?php

require_once 'db.php';

function fetch_results($pdo) {
	$statement_handle = $pdo->query("SELECT * FROM test_fixture");

	while($row = $statement_handle->fetch(PDO::FETCH_ASSOC)) {
		$results[] = $row;
	}

	return $results;
}

function transform($arry) {
	$results = array_map(function($a) {
		$a['data1'] = strrev($a['data1']);
		$a['data2'] = strrev($a['data2']);
		return $a;
	}, $arry);

	printf("memory inside transform: %smb\n", round(memory_get_usage()/1024/1024,2));

	return $results;
}



printf("memory before: %smb\n", round(memory_get_usage()/1024/1024,2));

$results_transformed = transform(fetch_results($pdo));

printf("memory after transform: %smb\n", round(memory_get_usage()/1024/1024,2));

$idx = 0;
foreach($results_transformed as $r) {
	if($idx++ > 10) break;
	printf("%s %s %s\n",$r['id'], substr($r['data1'],0,10), substr($r['data2'],0,10));
}

printf("memory after echo: %smb\n", round(memory_get_usage()/1024/1024,2));

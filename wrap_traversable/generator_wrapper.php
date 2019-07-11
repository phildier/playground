<?php

require_once 'db.php';

function query_wrapper($pdo, $query) {
	$statement_handle = $pdo->query($query);

	while($row = $statement_handle->fetch(PDO::FETCH_ASSOC)) {
		yield $row;
	}
}

function transform_wrapper($results) {
	foreach($results as $row) {
		printf("memory inside transform: %smb\n", round(memory_get_usage()/1024/1024,2));
		yield [
			'id' => $row['id'],
			'data1' => strrev($row['data1']),
			'data2' => strrev($row['data2']),
		];
	}
}

printf("memory before: %smb\n", round(memory_get_usage()/1024/1024,2));

$query = "SELECT * FROM test_fixture";

$results_generator = query_wrapper($pdo, $query);

$results_transformed = transform_wrapper($results_generator);

$idx = 0;
foreach($results_transformed as $r) {
	if($idx++ > 10) break;
	printf("%s %s %s\n",$r['id'], substr($r['data1'],0,10), substr($r['data2'],0,10));
}

printf("memory after echo: %smb\n", round(memory_get_usage()/1024/1024,2));

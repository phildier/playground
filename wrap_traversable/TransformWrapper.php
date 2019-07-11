<?php

class TransformWrapper extends TraversablePDOStatement {

	public function __construct($statement) {
		parent::__construct($statement,[]);
	}

	private function transform($row) {
		printf("memory inside transform: %smb\n", round(memory_get_usage()/1024/1024,2));
		return [
			'id' => $row['id'],
			'data1' => strrev($row['data1']),
			'data2' => strrev($row['data2']),
		];
	}

	public function current() {
		return $this->transform(parent::current());
	}
}

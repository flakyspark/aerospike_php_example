<?php
require_once __DIR__ . '/vendor/autoload.php';

use \Aerospike;


$config = [
    "hosts" => [
        ["addr" => "aerospike", "port" => 3000]
    ]
];

$db = new \Aerospike($config);

if (!$db->isConnected()) {
    echo "Failed to connect to the Aerospike server [{$db->errorno()}]: {$db->error()}\n";
    exit(1);
}

//$sql = <<<SQL
//CREATE TABLE snapshot_verification_result (
//  rule_id INTEGER,
//  trigger_id INTEGER,
//  answer_set_id INTEGER,
//  answer_source_type_id INTEGER,
//  client_id INTEGER,
//  result INTEGER,
//  trigger_hash VARCHAR(32),
//  created_date VARCHAR(20),
//  PRIMARY KEY (rule_id,trigger_id,answer_set_id,answer_source_type_id)
//);
//SQL;
//
//$result = $client->executeUpdate($sql);

echo 'Table created.' . PHP_EOL;

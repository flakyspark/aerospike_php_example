<?php
$config = [
    "hosts" => [
        ["addr" => "aerospike", "port" => 3000]
    ]
];

$db = new Aerospike($config);

if (!$db->isConnected()) {
    echo "Failed to connect to the Aerospike server [{$db->errorno()}]: {$db->error()}\n";
    exit(1);
}

// records are identified as a (namespace, set, primary-key) tuple
$key = $db->initKey("test", "snapshot_results", 'd41d8cd98f00b204e9800998ecf8427e');

$bins = ["name" => "Bender", "Occupation" => "Bender", "age" => 1055];

$status = $db->put($key, $bins, 0);

if ($status == Aerospike::OK) {
    echo "Record written.\n";
} elseif ($status == Aerospike::ERR_RECORD_EXISTS) {
    echo "The Aerospike server already has a record with the given key.\n";
} else {
    echo "[{$db->errorno()}] ".$db->error() . PHP_EOL;
}

$status = $db->get($key, $record);
if ($status == Aerospike::OK) {
    var_dump($record);
} elseif ($status == Aerospike::ERR_RECORD_NOT_FOUND) {
    echo "A user with key ". $key['key']. " does not exist in the database\n";
} else {
    echo "[{$db->errorno()}] ".$db->error() . PHP_EOL;
}

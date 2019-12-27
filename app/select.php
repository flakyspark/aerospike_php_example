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

$count = 0;
echo 'Processing...' . PHP_EOL;

$time_start = microtime(true);

for ($i=1 ; $i < 100000; $i ++) {
    $key = $db->initKey("test", "snapshot_results", md5(mt_rand(1, 50) . ' ' .  mt_rand(1, 50) . ' ' . mt_rand(1, 50) . ' ' . mt_rand(1, 50)));

    $status = $db->get($key, $record);
    if ($status == Aerospike::OK) {
        //ok
    } elseif ($status == Aerospike::ERR_RECORD_NOT_FOUND) {
        //echo "A user with key ". $key['key']. " does not exist in the database\n";
    } else {
        echo "[{$db->errorno()}] ".$db->error() . PHP_EOL;
    }

    $count++;
}

$time_end = microtime(true);
$time = $time_end - $time_start;

echo 'Finish. Selected ' . $count . ' rows' . PHP_EOL;
echo 'Time: ' . $time . PHP_EOL;

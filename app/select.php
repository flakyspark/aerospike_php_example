<?php
require_once __DIR__ . '/vendor/autoload.php';

use Tarantool\Client\Client;

$client = Client::fromOptions([
    'uri' => 'tarantool:3301'
]);

$count = 0;
echo 'Processing...' . PHP_EOL;

$time_start = microtime(true);

for ($i=1 ; $i < 100000; $i ++) {
    $select = "SELECT * FROM snapshot_verification_result  WHERE rule_id = ? AND trigger_id = ? AND answer_set_id = ? AND answer_source_type_id = ?";
    $result = $client->executeQuery($select, mt_rand(1, 50), mt_rand(1, 50), mt_rand(1, 50), mt_rand(1, 50));
    $result = $result->getData();
    $count++;
}

$time_end = microtime(true);
$time = $time_end - $time_start;

echo 'Finish. Selected ' . $count . ' rows' . PHP_EOL;
echo 'Time: ' . $time . PHP_EOL;

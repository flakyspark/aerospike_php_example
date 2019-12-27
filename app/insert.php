<?php
require_once __DIR__ . '/vendor/autoload.php';

use Tarantool\Client\Client;

$client = Client::fromOptions([
        'uri' => 'tarantool:3301'
    ]);

$count = 0;
echo 'Processing...' . PHP_EOL;

$time_start = microtime(true);

for ($ruleId=1 ; $ruleId < 100; $ruleId ++) {
    for ($triggerId=1 ; $triggerId < 100; $triggerId ++) {
        for ($answerSetId=1 ; $answerSetId < 10; $answerSetId ++) {
            $insert = "INSERT INTO snapshot_verification_result VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $result = $client->executeUpdate($insert, $ruleId, $triggerId, $answerSetId, mt_rand(1, 50), mt_rand(1, 30000), mt_rand(0,1), md5(mt_rand()), date("Y-m-d H:i:s"));
            $count++;
        }
    }
}

$time_end = microtime(true);
$time = $time_end - $time_start;

echo 'Finish. Inserted ' . $count . ' rows' . PHP_EOL;
echo 'Time: ' . $time . PHP_EOL;

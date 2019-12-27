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

for ($ruleId=1 ; $ruleId < 100; $ruleId ++) {
    for ($triggerId=1 ; $triggerId < 100; $triggerId ++) {
        for ($answerSetId=1 ; $answerSetId < 100; $answerSetId ++) {
            $answerSourceTypeId = mt_rand(1, 50);

            $key = $db->initKey("test", "snapshot_results", md5($ruleId . ' ' . $triggerId . ' ' . $answerSetId . ' ' . $answerSourceTypeId));

            $bins = [
                "rule_id" => $ruleId,
                "trigger_id" => $triggerId,
                "answer_set_id" => $answerSetId,
                "as_type_id" => $answerSourceTypeId,
                "client_id" => mt_rand(1, 30000),
                "result" => mt_rand(0,1),
                "trigger_hash" => md5(mt_rand()),
                "created_date" => date("Y-m-d H:i:s")
            ];

            $status = $db->put($key, $bins, 0);

            if ($status != Aerospike::OK) {
                if ($status == Aerospike::ERR_RECORD_EXISTS) {
                    echo "The Aerospike server already has a record with the given key.\n";
                } else {
                    echo "[{$db->errorno()}] " . $db->error() . PHP_EOL;
                }
            } else {
                $count++;
            }
        }
    }
}

$time_end = microtime(true);
$time = $time_end - $time_start;

echo 'Finish. Inserted ' . $count . ' rows' . PHP_EOL;
echo 'Time: ' . $time . PHP_EOL;

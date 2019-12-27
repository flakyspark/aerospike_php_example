<?php
require_once __DIR__ . '/vendor/autoload.php';

use Tarantool\Client\Client;

$client = Client::fromOptions([
        'uri' => 'tarantool:3301'
    ]);

$result = $client->executeUpdate("DROP TABLE snapshot_verification_result");

echo 'Table dropped' . PHP_EOL;

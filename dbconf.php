<?php

$dbOptions = array(
    'dbName' => "******",
    'dbHost' => "192.168.110.226",
    'dbPort' => 5432,
    'dbUser' => "*******",
    'dbPass' => "******"
);

$connectStr = "host=" . $dbOptions["dbHost"] . " port=" . $dbOptions["dbPort"] . " dbname=" . $dbOptions["dbName"] . " user=" . $dbOptions["dbUser"] . " password=" . $dbOptions["dbPass"] . "";
$conn = pg_connect( $connectStr );
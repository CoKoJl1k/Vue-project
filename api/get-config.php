<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$config = json_decode(file_get_contents(__DIR__ . '/config.json'));
echo json_encode($config);

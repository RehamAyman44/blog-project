<?php

$config = require __DIR__ . '/config.local.php';

$connect = mysqli_connect(
    $config['host'],
    $config['username'],
    $config['password'],
    $config['database']
);

if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}
<?php

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$test = $dotenv->load();


$tester = new Tests\TestAPIUnit();


$tester->it_work_auth();
echo 'test it_work_auth its OK!', PHP_EOL;

$tester->it_work_getUser();
echo 'test it_work_getUser its OK!', PHP_EOL;

$tester->it_work_setUser();
echo 'test it_work_setUser its OK!',PHP_EOL;

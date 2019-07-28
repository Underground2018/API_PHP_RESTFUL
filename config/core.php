<?php

error_reporting(E_ALL);
date_default_timezone_set('UTC');

$timestamp = time();
$timeAfter = strtotime("now");
$key = "example_key_jwt";
$iss = "http://localhost";
$aud = "http://localhost";
$iat = $timestamp;
$nbf = $timeAfter;
?>
<?php

$env = parse_ini_file('.env');
print_r($env);
exit();
$header = $env["HEADER"];

echo gettype($header) . "\n";
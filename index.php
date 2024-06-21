<?php

function autoload($class) {
$file = str_replace('\\', '/', $class) . '.php';
if (file_exists($file)) {
require $file;
}
}
$directory = './semennejo';
autoload($directory);
spl_autoload_register('autoload');

use semennejo\Loader;
use semennejo\tg_api;

$data = json_decode(file_get_contents('php://input'));
$tg_api = tg_api::create("7457933076:AAGqAwiFqLPDhC4CIdo5tD8Hh4PEPDQ-UP4");
new Loader($data, $tg_api);

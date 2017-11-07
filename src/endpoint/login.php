<?php

namespace Dusker;

use Dotenv\Dotenv;

$docRoot = getenv('DOCUMENT_ROOT');

while ($docRoot !== '/') {
    $vendor = glob($docRoot . '/vendor');
    if (!empty($vendor)) {
        require_once current($vendor) . '/autoload.php';
        break;
    }
    $docRoot = dirname($docRoot);
}

$dotenv = new Dotenv($docRoot);
$dotenv->load();

$login = $password = null;
extract(filter_input_array(
    INPUT_GET,
    [
        'login'    => FILTER_SANITIZE_STRING,
        'password' => FILTER_SANITIZE_STRING
    ]
), EXTR_IF_EXISTS);
echo Auth::login($login, $password);

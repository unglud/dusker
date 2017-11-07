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

list($login, $password) = filter_input_array(
    INPUT_GET,
    [
        'login'    => FILTER_SANITIZE_STRING,
        'password' => FILTER_SANITIZE_STRING
    ]
);
echo Auth::login($login, $password);

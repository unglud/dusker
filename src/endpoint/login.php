<?php

namespace Dusker;

list($login, $password) = filter_input_array(
    INPUT_GET,
    [
        'login'    => FILTER_SANITIZE_STRING,
        'password' => FILTER_SANITIZE_STRING
    ]
);
echo Auth::login($login, $password);

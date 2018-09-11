<?php

// require 'cms.php';
// phpinfo();
require 'vendor/kint.php';


echo 'Hello World!';
echo getenv('TEST_VAR__') ?? 'missing';
d(getenv('TEST_VAR__'));


echo '<br />';


echo false ? '' : '1234567';

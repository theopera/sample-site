<?php

use Opera\Component\WebApplication\WebApplication;
use Opera\SampleSite\MyContext;
use Opera\Component\Http\Request;
use Opera\Component\WebApplication\Configuration;

require '../vendor/autoload.php';

$configuration = new Configuration(parse_ini_file('../config.ini', true));
$app = new WebApplication(Request::createFromGlobals(), new MyContext($configuration));
$response = $app->run();

$response->send();
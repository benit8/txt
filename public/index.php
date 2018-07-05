<?php

define('WEBROOT', str_replace('index.php', '', $_SERVER['SCRIPT_NAME']));
define('ROOT',    str_replace('public/index.php', '', $_SERVER['SCRIPT_FILENAME']));

require_once(ROOT . "Core/Autoload.php");

date_default_timezone_set("Europe/Paris");

///////////////////////////////////////////////////////////////////////////////

new \App\Validators\BanValidator();


$app = new App\App();

$app->get('/', []);
$app->get('/([\w]+)/?', ['Board']);
$app->post('/([\w]+)/?', ['Board', 'createThread']);
$app->get('/([\w]+)/([\d]+)', ['Thread']);
$app->post('/([\w]+)/([\d]+)', ['Thread', 'insertReply']);

$app->get('.*', ['Error404']);

$app->run();
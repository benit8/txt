<?php

define('WEBROOT', str_replace('index.php', '', $_SERVER['SCRIPT_NAME']));
define('ROOT',    str_replace('public/index.php', '', $_SERVER['SCRIPT_FILENAME']));

date_default_timezone_set("Europe/Paris");

require_once(ROOT . "Core/Autoload.php");

///////////////////////////////////////////////////////////////////////////////

new \App\Validators\BanValidator();


$app = new Core\App();

$app->get('/', []);
$app->get('/([\w]+)/?', ['Board']);
$app->post('/([\w]+)/?', ['Board', 'createThread']);
$app->get('/([\w]+)/([\d]+)', ['Thread']);
$app->post('/([\w]+)/([\d]+)', ['Thread', 'insertReply']);

$app->run();
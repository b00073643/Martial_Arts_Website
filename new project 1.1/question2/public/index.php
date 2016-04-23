<?php
// autoloader& other setup
// ---------------------------------------
require_once __DIR__ . '/../app/setup.php';

//-------------------------------------------
// map routes to controller class/method
//-------------------------------------------
use Itb\ControllerUtility;

$app->get('/',          ControllerUtility::controller('Itb', 'main/index'));
$app->get('/list',      ControllerUtility::controller('Itb', 'main/list'));
$app->get('/show/{id}', ControllerUtility::controller('Itb', 'main/show'));
$app->get('/show/', ControllerUtility::controller('Itb', 'main/showMissingIsbn'));

$app->error(function (\Exception $e, $code) use ($app) {
    $errorController = new Itb\ErrorController();
    return $errorController->errorAction($app, $code);
});

// go - process request and decide what to do
//---------------------------------------------
$app->run();


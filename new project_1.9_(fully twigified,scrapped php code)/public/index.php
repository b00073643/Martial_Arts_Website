<?php
// load classes
// ---------------------------------------
session_start();

require_once __DIR__ . '/../vendor/autoload.php';

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'itb');

$templatesPath = __DIR__.'/../templates';
$app = new \Silex\Application();
$app['debug'] = true;

$app->register(new Silex\Provider\TwigServiceProvider(),[
    'twig.path'=>$templatesPath
]);
$app->get('/','Itb\Controller\MainController::indexAction');
$app->get('/show/','Itb\Controller\MainController::showMissingAction');
$app->get('/showStudent','Itb\Controller\MainController::showStudents');
$app->get('/login','Itb\Controller\LoginController::loginAdminAction');
$app->get('/studentLogin','Itb\Controller\LoginController::loginStudentAction');
$app->post('/processAdminLogin','Itb\Controller\LoginController::processLoginAction');
$app->post('/processStudentLogin','Itb\Controller\LoginController::processStudentLogin');
$app->get('/loginProcess/{username}','Itb\Controller\LoginController::printName');
$app->get('/showUsers/{id}','Itb\Controller\MainController::showAction');
$app->get('/userlist','Itb\Controller\MainController::listAction');
$app->post('/addUser','Itb\Controller\LoginController::addUser');
$app->get('/addUserForm','Itb\Controller\LoginController::addUserForm');
$app->get('/addStudentForm','Itb\Controller\AdminController::addStudentForm');
$app->post('/addStudent','Itb\Controller\LoginController::addStudent');
$app->get('/logout','Itb\Controller\LoginController::logoutAction');
$app->get('/showStudent/{id}','Itb\Controller\MainController::showSingleStudent');
$app->get('/addTechniqueSeen/{id}','Itb\Controller\AdminController::addTechniqueSeen');
$app->post('/addStudent','Itb\Controller\LoginController::addStudent');
$app->post('/deleteStudent','Itb\Controller\AdminController::deleteStudent');
$app->get('/attendance','Itb\Controller\AdminController::attendance');
$app->post('/markAttendance','Itb\Controller\AdminController::markAttendance');
$app->post('/processAttendance','Itb\Controller\AttendanceController::processAttendance');
$app->get('/percentAttendance','Itb\Controller\AttendanceController::getPercentageAttendance');



$app->error(function (\Exception $e, $code) use ($app) {

    $mainController = new \Itb\Controller\MainController();
    return $mainController->errorAction($app, $code);
});

$app->run();

?>


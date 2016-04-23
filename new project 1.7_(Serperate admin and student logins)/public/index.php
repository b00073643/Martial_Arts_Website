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
$app->get('/login','Itb\Controller\LoginController::loginAction');
$app->get('/studentLogin','Itb\Controller\LoginController::loginAction');
$app->get('/loginProcess/{username}/{password}','Itb\Controller\LoginController::processLoginAction');
$app->get('/studentLogin/{username}/{password}','Itb\Controller\LoginController::loginStudentProcess');
$app->get('/loginProcess/{username}','Itb\Controller\LoginController::printName');
$app->get('/showUsers/{id}','Itb\Controller\MainController::showAction');
$app->get('/userlist','Itb\Controller\MainController::listAction');
$app->get('/addUser/{username}/{password}/{role}','Itb\Controller\LoginController::addUser');
$app->get('/addUser','Itb\Controller\LoginController::addUserForm');
$app->get('/addStudent','Itb\Controller\LoginController::addStudentForm');
$app->get('/logout','Itb\Controller\LoginController::logoutAction');
$app->get('/showStudent/{id}','Itb\Controller\MainController::showSingleStudent');
$app->get('/addTechniqueSeen/{id}','Itb\Controller\AdminController::addTechniqueSeen');

$app->error(function (\Exception $e, $code) use ($app) {

    $mainController = new \Itb\Controller\MainController();
    return $mainController->errorAction($app, $code);
});

$action = filter_input(INPUT_GET,'action',FILTER_SANITIZE_STRING);

switch ($action){

    case 'processLogin':
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
      //  print "$username and $password";
        header("Location: /loginProcess/{$username}/{$password}"); /* Redirect browser */
        exit();
        break;

    case 'processStudentLogin':
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        //  print "$username and $password";
        header("Location: /loginProcess/{$username}/{$password}"); /* Redirect browser */
        exit();
        break;
    //---------- main ROUTES ---------------
    case 'addUser':

        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);
        header("Location: /addUser/{$username}/{$password}/{$role}"); /* Redirect browser */
        exit();
        break;

}
$app->run();

?>


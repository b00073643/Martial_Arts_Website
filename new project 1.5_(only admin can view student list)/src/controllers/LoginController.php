<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 16/04/2016
 * Time: 00:40
 */

namespace Itb\Controller;

use Itb\Model\User;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class LoginController
{

    public function logoutAction(Request $request, Application $app)
    {
        // remove 'user' element from SESSION array
        unset($_SESSION['user']);
        unset($_SESSION['role']);

        $argsArray = [
            'user'=>''
        ];

        $templateName = 'index';
        return $app['twig']->render($templateName . '.html.twig',$argsArray);


        // redirect to index action

    }
    public function loginAction(Request $request, Application $app)
    {
        $templateName = 'login';
        return $app['twig']->render($templateName . '.html.twig',[]);
    }

    public function printName(Request $request, Application $app,$username)
    {
        echo"$username";
        $argArray = ['user'=>$username];
        $templateName = 'loginSuccess';
        return $app['twig']->render($templateName . '.html.twig',$argArray);
    }

    public function addUserForm(Request $request, Application $app)
    {

        $templateName = '/addUser';
        return $app['twig']->render($templateName . '.html.twig',[]);
    }
    public function addUser(Request $request, Application $app,$username,$password,$role)
    {
        $user = new User();
        $user->setUsername($username);
        $user->setPassword($password);
        if($role=='admin') {
            $user->setRole(User::ROLE_ADMIN);
        }
        else if($role == 'user'){
            $user->setRole(User::ROLE_USER);

        }
        User::insert($user);

        $argsArray=['user'=>$user];
        $templateName = '/showSingleUser';
        return $app['twig']->render($templateName . '.html.twig',$argsArray);
    }


    public function processLoginAction(Request $request, Application $app,$username,$password)
    {
        // default is bad login
        $isLoggedIn = false;

        // search for user with username in repository
        $isLoggedIn = User::canFindMatchingUsernameAndPassword($username, $password);
      //  $user =  User::getOneByUsername($username);

        // action depending on login success
        if($isLoggedIn){
            $isAdmin = User::canFindMatchingAdminUsernameAndPassword($username, $password);
            if($isAdmin=='1')
            {
                $_SESSION['role']='admin';
            }
            else{
                $_SESSION['role']='user';

            }
            User::getOneByUsername($username);
            // STORE login status SESSION
            $_SESSION['user'] = $username;

            $argsArray = ['user' => $username, 'pass' =>$password];
            $templateName = 'loginSuccess';
            return $app['twig']->render($templateName . '.html.twig',$argsArray);

       //     require_once __DIR__ . '/../templates/loginSuccess.php';
        } else {
            $argsArray = ['user' => $username];
           $templateName = 'loginFail';
            return $app['twig']->render($templateName . '.html.twig',$argsArray);
        }
    }

    public function isLoggedInFromSession()
    {
        $isAdminLoggedIn = false;

        // user is logged in if there is a 'user' entry in the SESSION superglobal
        if(isset($_SESSION['user'])&& $_SESSION['role']=='admin'){
            $isAdminLoggedIn = true;
        }

        return $isAdminLoggedIn;
    }

    public function usernameFromSession()
    {
        $username = '';

        // extract username from SESSION superglobal
        if (isset($_SESSION['user'])) {
            $username = $_SESSION['user'];
        }

        return $username;
    }
}
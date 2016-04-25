<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 16/04/2016
 * Time: 00:40
 */

namespace Itb\Controller;


use Itb\Model\User;
use Itb\Model\Student;
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
            'user' => ''
        ];

        $templateName = 'index';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);


        // redirect to index action

    }


    public function loginStudentAction(Request $request, Application $app)
    {
        $templateName = 'login';
        $action = 'processStudentLogin';
        $argsArray=['action'=>$action];
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }
    public function loginAdminAction(Request $request, Application $app)
    {
        $action = 'processAdminLogin';
        $templateName = 'login';
        $argsArray=['action'=>$action];
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }
    public function printName(Request $request, Application $app, $username)
    {
        echo "$username";
        $argArray = ['user' => $username];
        $templateName = 'loginSuccess';
        return $app['twig']->render($templateName . '.html.twig', $argArray);
    }

    public function addUserForm(Request $request, Application $app)
    {
        $templateName = 'admin/addUser';
        return $app['twig']->render($templateName . '.html.twig', []);
    }


    public function addUser(Request $request, Application $app)
    {
        $username = $request->get('username');
        $password = $request->get('password');
        $user = new User();
        $user->setUsername($username);
        $user->setPassword($password);
        $user->setRole(User::ROLE_ADMIN);

        User::insert($user);

        $argsArray = ['user' => $user];
        $templateName = '/showSingleUser';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    public function addStudent(Request $request, Application $app)
    {

        $firstName = $request->get('firstName');
        $surname=$request->get('surname');
        $password=$request->get('password');
        $attendsClass=$request->get('classType');

        $ts =new \DateTime();
        $t=$ts->getTimestamp();
        $date = new \DateTime();
        $student = new Student();
//        $student->setId(25);
        $student->setSurname($surname);
        $student->setFirstName($firstName);
        $student->setPassword($password);
        $student->setJoinDate($date->format('d-m-Y'));
        $student->setLastGrading('');
        $student->setCurrentGrade('1');
        $student->setAvgGrade('B');
        $student->setSeen(1);
        $student->setAttendsClass($attendsClass);
        $student->setTotalAttendedPercentage(22);

//        var_dump($student);

        Student::insert($student);

        $argsArray = ['student' => $student];
        $templateName = '/student/showSingleStudent';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);

    }


    public function processStudentLogin(Request $request, Application $app)
    {
        $username = $request->get('username');
        $password = $request->get('password');
        print 'username is '.$username.' amd password is '.$password;
        // default is bad login
        $isLoggedIn = false;

        // search for user with username in repository
        $studentLogin1 = Student::canFindMatchingUsernameAndPassword();
        $studentLogin = Student::canFindMatchingUsernameAndPassword($username,$password);
        print 'in aaaaaaaaaaa';

        // action depending on login success
        if($studentLogin){
            print 'in hereeeere';
            die();
            // User::set
                $_SESSION['role']='user';

            Student::getOneByUsername($username);
            // STORE login status SESSION
            $_SESSION['user'] = $username;

            $argsArray = ['user' => $username, 'pass' =>$password];
            $templateName = 'loginSuccess';
            return $app['twig']->render($templateName . '.html.twig',$argsArray);

            //     require_once __DIR__ . '/../templates/loginSuccess.php';
        } else {
            print 'in heooooooooooooooreeeere';

            $argsArray = ['user' => $username];
            $templateName = 'loginFail';
            return $app['twig']->render($templateName . '.html.twig',$argsArray);
        }
    }

    public function processLoginAction(Request $request, Application $app)
    {
        $username = $request->get('username');
        $password = $request->get('password');
        print 'username is '.$username;
        // default is bad login
        $isLoggedIn = false;

        // search for user with username in repository
        $isLoggedIn = User::canFindMatchingUsernameAndPassword($username, $password);





        //  $user =  User::getOneByUsername($username);
        // action depending on login success
        if($isLoggedIn){
           // User::set

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
    {print'logggg';
        die();
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
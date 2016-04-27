<?php

namespace Itb\Controller;

use Itb\Model\Student;
use Itb\Model\User;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class MainController
{

    public function indexAction(Request $request, Application $app)
    {

        //$templateName = 'index';
        $argsArray=['user'=>'user'];
        if(isset($_SESSION['user']))
        {

            $argsArray=['user'=>$_SESSION['user']];
            print'session user is set ';

        }
        if(ISSET($_SESSION['role']))
        {
            print'<br>session user is set to '.$_SESSION['role'].' outside of if';

            if($_SESSION['role']='admin') {
                print'<br>session user is set to '.$_SESSION['role'].' inside of if statement';

                $templateName = 'admin/adminIndex';
                return $app['twig']->render($templateName . '.html.twig', $argsArray);

            }

            else if($_SESSION['role']='user') {
                print'session user is set to user inside if statement';
                $templateName = 'student/studentIndex';
                return $app['twig']->render($templateName . '.html.twig', $argsArray);

            }

        }
        else{
//            print'heeer';
//            die();
            $templateName = 'index';
            return $app['twig']->render($templateName . '.html.twig', $argsArray);
        }
    }



    public function listAction(Request $request, Application $app)
    {
        $users = User::getAll();
        $argsArray = [
            'users'=> $users
        ];
        $templateName = 'listUsers';

        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    public function showStudents(Request $request, Application $app)
{

    if(ISSET($_SESSION['role'])) {

        if($_SESSION['role']=='admin') {

            $students = Student::getAll();
            foreach($students as $student)
            {
                $student->setTotalAttendedPercentage();
            }
            $argsArray = [
                'students' => $students
            ];
            $templateName = 'admin/studentListWithDelete';
        }
        else{
            $message ='Sorry we are afraid you have tried to select an admin feature';
            $argsArray = [
                'message' => $message
            ];
            $templateName = 'error';
        }
            return $app['twig']->render($templateName . '.html.twig', $argsArray);

    }
}

    public function showSingleStudent(Request $request, Application $app,$id)
    {
        if(ISSET($_SESSION['role'])) {

            if($_SESSION['role']=='admin') {
                $student = Student::getOneById($id);


                $argsArray = [
                    'student' => $student,
                ];
                $templateName = 'student/showSingleStudent';

                return $app['twig']->render($templateName . '.html.twig', $argsArray);
            }
        }
    }

    public function showMissingAction(Request $request, Application $app)
    {

        $message= 'Sorry no ID was entered';

        $argsArray = [
            'message'=> $message
        ];
        $templateName='error';

        return $app['twig']->render($templateName . '.html.twig', $argsArray);

    }

    public function errorAction(Application $app, $code)
    {
        $message = '404 Error sorry cant find resource';
        if($code != 404)
        {
            $message='Sorry UNKOWN ERROR OCCURRED';
        }
        $argsArray = [
            'message'=> $message
        ];
        $templateName='error';

        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }


}


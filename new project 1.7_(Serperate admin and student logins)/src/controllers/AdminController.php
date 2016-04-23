<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 16/04/2016
 * Time: 11:15
 */

namespace Itb\Controller;

use Itb\Model\Student;
use Itb\Model\User;

use Itb\StudentManager\StudentManager;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class AdminController
{

    public function adminHomeAction(Request $request, Application $app)
    {
        $isLoggedIn = $this->loginController->isAdminLoggedInFromSession();
        if ($isLoggedIn){
            $username = $this->loginController->usernameFromSession();
            $templateName = 'adminIndex';
            $argsArray=['user'=>$username];
            return $app['twig']->render($templateName . '.html.twig',$argsArray);


        } else {
            $templateName = 'loginFail';

            $message = 'UNAUTHORIZED ACCESS - the Guards are on their way to arrest you ...';
            $argsArray=['message'=>$message];

            return $app['twig']->render($templateName . '.html.twig',$argsArray);
        }
    }

    public function addTechniqueSeen(Request $request,Application $app,$id)
    {
        if(ISSET($_SESSION['role']))
        {
            if ($_SESSION['role']=='admin')
            {
                $isLoggedIn=true;
            }
        }
        if ($isLoggedIn) {
            $student = Student::getOneById($id);

            $oldSeen = $student->getSeen();
            $newS = $student->addOneToSeen($oldSeen);
            $student->setSeen($newS);
            $newSeen = $student->getSeen();

            $updateSuccess = Student::update($student);
//
            $argsArray = [
                'student' => $student,
                'oldseen' => $oldSeen,
                'newseen' => $newSeen
            ];
            $templateName = 'student/showSingleStudent';
        }
        else{
            $templateName = 'error';
            $message = 'Sorry you do not have permission to do this';
            $argsArray = [
                'message' => $message

            ];

        }
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

}
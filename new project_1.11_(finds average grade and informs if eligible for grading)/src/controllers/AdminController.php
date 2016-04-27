<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 16/04/2016
 * Time: 11:15
 */

namespace Itb\Controller;

use Itb\Model\Attendance;
use Itb\Model\Student;
use Itb\Model\User;
use Itb\Model\Session;

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

    public function attendance(Request $request, Application $app)
    {

        $username = $_SESSION['user'];
    $templateName = 'admin/attendance';
    $argsArray=['user'=>$username];
    return $app['twig']->render($templateName . '.html.twig',$argsArray);

    }
    //////////////////////////////////////////////////////not used yet//////////////////////////////////////
            public function timeSince()
            {
                $time = strtotime('2010-04-28 17:25:43');

                echo 'event happened '.($time).' ago';

                $time = time() - $time; // to get the time since that moment
                $time = ($time<1)? 1 : $time;
                $token = 2592000;

                $numberOfUnits = floor($time / $token);
                $months = $numberOfUnits .'Months since last grading';
                echo '<br>' . $months;
            }



    public function markAttendance(Request $request, Application $app)
    {
        $class = $request->get('classes');
        print $class.'<br>';
        $month = $request->get('JoinMonth');
        $day = $request->get('JoinDay');
        $year = $request->get('JoinYear');
//            $username = $_SESSION['user'];
        print "the date is $day /$month/$year";
        $dateString = $day.'-'.$month.'-'.$year;
        $timestamp = strtotime("$day-$month-$year");
        print '<br>'.$timestamp;
        $class1 = Session::getOneById($class);
//        var_dump($class1) ;
//        die()
        $attendances = Attendance::getAll();

        $students = Student::searchByColumn('attendsClass',$class);

        $templateName = 'admin/markAttendance';

        $argsArray=[
            'students'=>$students,
            'class'=>$class1,
            'dateString'=>$dateString,
            'attendances'=>$attendances
        ];

        return $app['twig']->render($templateName . '.html.twig',$argsArray);

    }

    public function addStudentForm(Request $request, Application $app)
    {

        $templateName = '/admin/addStudent';
        return $app['twig']->render($templateName . '.html.twig', []);
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
    public function deleteStudent(Request $request, Application $app)
    {

        $id = $request->get('id');
        print $id;
        $deleteSuccess = Student::delete($id);
        if($deleteSuccess){
            $students = Student::getAll();
            $templateName = 'admin/studentListWithDelete';
            $argsArray=['students'=>$students];

            return $app['twig']->render($templateName . '.html.twig', $argsArray);
        } else {
            $templateName = 'error';
            $message = "error - not able to DELETE item with id = $id";
            $argsArray=['message'=>$message];
            return $app['twig']->render($templateName . '.html.twig', $argsArray);
        }

    }


}
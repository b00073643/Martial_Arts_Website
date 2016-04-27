<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 22/04/2016
 * Time: 21:58
 */

namespace Itb\Controller;

use Itb\Model\Attendance;
use Itb\Model\Student;
use Itb\Model\User;
use Itb\Model\Session;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class AttendanceController
{
    public function processAttendance(Request $request, Application $app)
    {
        $studentId = $request->get('id');
        $sessionId = $request->get('sessionId');
        $dateString = $request->get('dateString');
        print $dateString;
        $atten = $request->get('atten');
        $class1 = $request->get('sessionId');

        $attendance = new Attendance();
        $attendance->setSessionId($sessionId);
        $attendance->setStudentId($studentId);
        $attendance->setDate($dateString);
        if($atten>0) {
            $attendance->setPresent(1);
            $attendance->setAbscent(0);
        }
        else{
            $attendance->setPresent(0);
            $attendance->setAbscent(1);
        }

        Attendance::insert($attendance);
//         die();
        $class = Session::getOneById($class1);

        $students = Student::searchByColumn('attendsClass',$class1);
        $attendances = Attendance::getAll();
        $templateName = 'admin/markAttendance';

        $argsArray=[
            'students'=>$students,
            'class'=>$class,
            'dateString'=>$dateString,
            'attendances'=>$attendances
        ];
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
//        echo $date->format('U = Y-m-d H:i:s') . "\n";

//        $timestamp = $date->getTimestamp();
//

    }

    public function getPercentageAttendance(Request $request,Application $app)
    {
        $student = Student::getOneById(10);
//        var_dump($student);
        $student->setTotalAttendedPercentage();
        print '<br>get'.$student->getTotalAttendedPercentage();
       //$updateSuccess = Student::update($student);

        die();
        return $app['twig']->render($templateName . '.html.twig', []);

    }
}
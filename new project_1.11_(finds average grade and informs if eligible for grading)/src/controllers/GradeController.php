<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 26/04/2016
 * Time: 21:00
 */

namespace Itb\Controller;

use Itb\Model\Attendance;
use Itb\Model\Grade;
use Itb\Model\Student;
use Itb\Model\Technique;
use Itb\Model\User;
use Itb\Model\Session;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class GradeController
{
    function updateGrade(Request $request,Application $app)
    {
        $score =$request->get('score');
        $studentId =$request->get('studentId');
        $techniqueId =$request->get('techniqueId');
        $tech = Technique::getOneById($techniqueId);
        $techName = $tech->getName();
        print'updateGrade with score '.$score.' and the techniques name is '.$techName.'<br>';
        $gradeId = Grade::getGradeIdFromStudentIdandTechniqueId($studentId,$techniqueId);

        $grade = new Grade();
        $grade->setId($gradeId);
        $grade->setScore($score);
        $grade->setStudentId($studentId);
        $grade->setTechniqueId($techniqueId);
        $student = Student::getOneById($studentId);
        $technique= Technique::getOneById($techniqueId);
        Grade::update($grade);

        $grades = Grade::searchByColumn('studentId',$studentId);
        $total=0;
        foreach($grades as $g)
        {
           $total = $total+ $g->getScore();
//            die();
        }
        print $total.' of '.$student->getFirstName().' is the 3 techniques added together';
        $averageGrade=$total/3;
        print'<br> and the average is '.$averageGrade;

        $eligibility = 'not ready yet for grading';

        if($averageGrade>3)
        {
            $eligibility = 'ready to grade to next belt';
        }
        $techs = Technique::searchByColumn('belt',$student->getCurrentGrade());
        $argsArray = [
            'technique' => $technique,
            'student'=>$student,
            'grade'=>$grade,
            'grades'=>$grades,
            'techs'=>$techs,
            'eligibility'=>$eligibility
        ];

        $templateName = 'admin/showStudentScores';
//        print'updateGrade form';
//        die();
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    function updateGradeForm(Request $request,Application $app)
    {
        $studentId = $request->get('studentId');
        $student = Student::getOneById($studentId);
        $belt = $student->getCurrentGrade();
//        print'belt is '.$belt;
        $techniqueToBeUpdated = Technique::searchByColumn('belt',$belt);

        $argsArray = [
            'techniques' => $techniqueToBeUpdated,
            'student'=>$student,
//            'grades'=>$allGrades
        ];

        $templateName = 'admin/showStudentTechniques';

        return $app['twig']->render($templateName . '.html.twig', $argsArray);

//        $studentName= $student->getFirstName();
//
//        foreach($techniqueToBeUpdated as $g)
//        {
//            print'heor';
//            die();
//            $n=$g->getName();
//            print'<br>student '.$studentName.' has technique '.$n.' to be upgraded<br>';
//            $gradeTableStudentId = Grade::s
//
//            $techId = $g->getId();
//            $grade->setTechniqueId($techId);
//            $grade->setStudentId($studentId);
//            $grade->setScore($score);
//
//            Grade::update($grade);
//        }


    }
    function fillGrades(Request $request,Application $app)
    {

        $students = Student::getAll();
        $totalGrades = Grade::getAll();
        if (empty($totalGrades)) {
            foreach ($students as $student) {
                $studentId = $student->getId();
                $name = $student->getFirstName();
                $surname = $student->getSurname();
                $belt = $student->getCurrentGrade();
//            print '<br>student '.$name.' '.$surname.' is on belt '.$belt;

                $techniques = Technique::searchByColumn('belt', $belt);
                foreach ($techniques as $tech) {
                    $grade = new Grade();

                    $techId = $tech->getId();
                    $grade->setTechniqueId($techId);
                    $grade->setStudentId($studentId);
                    $grade->setScore(0);
                    Grade::insert($grade);


                }
            }
        } else {

            foreach ($students as $student) {

                $studentId = $student->getId();
                $name = $student->getFirstName();
                $surname = $student->getSurname();
                $belt = $student->getCurrentGrade();
//            print '<br>student '.$name.' '.$surname.' is on belt '.$belt;

                $techniques = Technique::searchByColumn('belt', $belt);
                foreach ($techniques as $tech) {
                    $grade = new Grade();

                    $techId = $tech->getId();
                    $grade->setTechniqueId($techId);
                    $grade->setStudentId($studentId);
                    $grade->setScore(0);

                    Grade::update($grade);

                }


            }
        }
        $allGrades = Grade::getAll();
        $argsArray = [
            'techniques' => $techniques,
            'students'=>$students,
            'grades'=>$allGrades
        ];
        $templateName = 'admin/adminIndex';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }
}


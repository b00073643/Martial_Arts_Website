<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 26/04/2016
 * Time: 00:46
 */

namespace Itb\Model;


use Mattsmithdev\PdoCrud\DatabaseTable;

class Grade extends DatabaseTable
{
    private $id;
    private $studentId;
    private $techniqueId;
    private $score;

    public static function canFindMatchingUsernameAndPassword($username, $password)
    {
        $user = Student::getOneByUsername($username);

        // if no record has this username, return FALSE
        if(null == $user){
            return false;
        }

        // hashed correct password
        $hashedStoredPassword = $user->getPassword();

        // return whether or not hash of input password matches stored hash
        return password_verify($password, $hashedStoredPassword);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getStudentId()
    {
        return $this->studentId;
    }

    /**
     * @param mixed $studentId
     */
    public function setStudentId($studentId)
    {
        $this->studentId = $studentId;
    }

    /**
     * @return mixed
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @param mixed $score
     */
    public function setScore($score)
    {
        $this->score = $score;
    }

    /**
     * @return mixed
     */
    public function getTechniqueId()
    {
        return $this->techniqueId;
    }

    /**
     * @param mixed $technique
     */
    public function setTechniqueId($techniqueId)
    {
        $this->techniqueId = $techniqueId;
    }

    public static function getGradeIdFromStudentIdandTechniqueId($studentId, $techniqueId)
    {
        $grades = Grade::searchByColumn('studentId',$studentId);
        foreach($grades as $grade)
        {
            if ($grade->getTechniqueId() == $techniqueId)
            {
                $gradeId= $grade->getId();
                return $gradeId;
//                print $grade->getId().'is the grade id and '.$studentId.' is the students id';
            }
        }

            return false;
    }

}
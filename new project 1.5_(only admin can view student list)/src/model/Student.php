<?php
namespace Itb\Model;
use Mattsmithdev\PdoCrud\DatabaseTable;
use Mattsmithdev\PdoCrud\DatabaseManager;

class Student extends DatabaseTable
{
    /**
     * the objects unique ID
     * @var int
     */
    private $id;
    /**
     * @var string $title
     */
    private $surname;
    /**
     * (should become ID of separate CATEGORY class ...)
     * @var string $category
     */
    private $firstname;
    /**
     * @var float
     */
    private $joindate;
    /**
     * integer value from 0 .. 100
     * @var integer
     */
    private $lastgrading;
    /**
     * @var integer
     */
    private $currentgrade;
    /**
     * @return int
     */
    private $gradeAverage;

    private $age;

    public function getId()
    {
        return $this->id;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function getFirstName()
    {
        return $this->firstname;
    }

    public function getJoinDate()
    {
        return $this->joindate;
    }

    public function getGradeAverage()
    {
        return $this->gradeAverage;
    }

    public function getLastGrading()
    {
        return $this->lastgrading;
    }

    public function getCurrentGrade()
    {
        return $this->currentgrade;
    }

}
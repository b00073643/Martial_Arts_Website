<?php
namespace Itb\Model;

use Mattsmithdev\PdoCrud\DatabaseTable;
use Mattsmithdev\PdoCrud\DatabaseManager;

class Student extends DatabaseTable
{

    private $id;
    private $surname;
    private $firstName;
    private $password;
    private $joinDate;
    private $lastGrading;
    private $currentGrade;
    private $avgGrade;
    private $seen;
    private $attendsClass;
    private $totalAttendedPercentage;
//    private $totalAttended;
//    private $totalMissed;



    public function getTotalAttendedPercentage()
    {
        return $this->totalAttendedPercentage;
    }
    public function setTotalAttendedPercentage()
    {
        $studentAttendance = Attendance::searchByColumn('studentId',$this->id);
        $totalPresent=0;
        $totalAbscent=0;
        foreach ($studentAttendance as $sa) {
            $totalPresent+=$sa->getPresent();
            print $totalPresent;
            $totalAbscent+=$sa->getAbscent();
            print $totalAbscent;

        }

        $totalClasses=$totalPresent+$totalAbscent;
        if ($totalClasses < 1) {
            $this->totalAttendedPercentage=0;
        }
        else {
//            print '<br>'.$this->surname.'<br> total classes = '.$totalClasses.'<br>total present = '.$totalPresent.'<br>total abscent = '.$totalAbscent.'<hr>';
            $percent = (100 * $totalPresent) / $totalClasses;
            $this->totalAttendedPercentage = intval($percent);
        }
}
    /**
     * @return mixed
     */
    public function getTotalClasses()
    {
        return $this->totalClasses;
    }

    /**
     * @param mixed $totalClasses
     */
    public function setTotalClasses($totalClasses)
    {
        $this->totalClasses = $totalClasses;
    }


    /**
     * @return mixed
     */
    public function getAttendsClass()
    {
        return $this->attendsClass;
    }

    /**
     * @param mixed $attendsClass
     */
    public function setAttendsClass($attendsClass)
    {
        $this->attendsClass = $attendsClass;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return float
     */
    public function getJoinDate()
    {
        return $this->joinDate;
    }

    /**
     * @param float $joinDate
     */
    public function setJoinDate($joinDate)
    {
        $this->joinDate = $joinDate;
    }

    /**
     * @return int
     */
    public function getLastGrading()
    {
        return $this->lastGrading;
    }

    /**
     * @param int $lastGrading
     */
    public function setLastGrading($lastGrading)
    {
        $this->lastGrading = $lastGrading;
    }

    /**
     * @return int
     */
    public function getCurrentGrade()
    {
        return $this->currentGrade;
    }

    /**
     * @param int $currentGrade
     */
    public function setCurrentGrade($currentGrade)
    {
        $this->currentGrade = $currentGrade;
    }

    /**
     * @return mixed
     */
    public function getAvgGrade()
    {
        return $this->avgGrade;
    }

    /**
     * @param mixed $avgGrade
     */
    public function setAvgGrade($avgGrade)
    {
        $this->avgGrade = $avgGrade;
    }

    /**
     * @return int
     */
    public function getSeen()
    {
        return $this->seen;
    }

    /**
     * @param int $seen
     */
    public function setSeen($seen)
    {
        $this->seen = $seen;
    }





    public static function update(Student $student)
    {
        $id=2;
        $isOnDatabase = Student::getOneById($id);
        $id = $student->getId();
        $seen = $student->getSeen();
        $totalAttendedPercentage = $student->getTotalAttendedPercentage();
        echo"$id and $seen";
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = 'UPDATE students SET seen = :seen, totalAttendedPercentage= :totalAttendedPercentage WHERE id=:id';
        $statement = $connection->prepare($sql);
        $statement->bindParam(':seen', $seen, \PDO::PARAM_INT);
        $statement->bindParam(':id', $id, \PDO::PARAM_INT);

        $queryWasSuccessful = $statement->execute();

        /*        return $queryWasSuccessful;*/
    }
    public function setPassword($password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $this->password = $hashedPassword;
    }

    public function addOneToSeen($seen)
    {

        $this->seen = $seen+1;
        return $this->seen;
    }


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


    public static function getOneByUsername($username)
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = 'SELECT * FROM student WHERE username=:username';
        $statement = $connection->prepare($sql);
        $statement->bindParam(':username', $username, \PDO::PARAM_STR);
        $statement->setFetchMode(\PDO::FETCH_CLASS, __CLASS__);
        $statement->execute();

        if ($object = $statement->fetch()) {
            return $object;
        } else {
            return null;
        }
    }

}
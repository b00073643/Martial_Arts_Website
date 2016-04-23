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
    private $currentgrade='blue';
    /**
     * @return int
     */
    private $gradeAverage=2;
    private $seen=0;
    public static function update(Student $student)
    {
        $id=2;
        $isOnDatabase = Student::getOneById($id);
        $id = $student->getId();
        $seen = $student->getSeen();
        echo"$id and $seen";
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = 'UPDATE students SET seen = :seen WHERE id=:id';
        $statement = $connection->prepare($sql);
        $statement->bindParam(':seen', $seen, \PDO::PARAM_INT);
        $statement->bindParam(':id', $id, \PDO::PARAM_INT);

        $queryWasSuccessful = $statement->execute();

        /*        return $queryWasSuccessful;*/
    }

    public function getId()
    {
        return $this->id;
    }
    public function getSeen()
    {
        return $this->seen;
    }
    public function setSeen($seen)
    {

        $this->seen;
    }
    public function addOneToSeen($seen)
    {

        $this->seen = $seen+1;
        return $this->seen;
    }
    public function getNumTechniques()
    {
        return $this->seen;
    }
    public function getSurname()
    {
        return $this->surname;
    }

    public function getFirstName()
    {
        return $this->firstname;
    }

    public function setFirstName($n)
    {
        $this->firstname = $n;
    }

    public function getJoinDate()
    {
        return $this->joindate;
    }

    public function getGradeAverage()
    {
        return $this->gradeAverage;
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

    public function getLastGrading()
    {
        return $this->lastgrading;
    }

    public function getCurrentGrade()
    {
        return $this->currentgrade;
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
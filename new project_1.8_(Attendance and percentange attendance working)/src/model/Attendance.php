<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 20/04/2016
 * Time: 19:11
 */

namespace Itb\Model;


use Mattsmithdev\PdoCrud\DatabaseTable;

class Attendance extends DatabaseTable
{
    private $id;
    private $sessionId;
    private $studentId;
    private $date;
    private $present;
    private $abscent;

    /**
     * @return mixed
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * @param mixed $sessionId
     */
    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;
    }


    /**
     * @return mixed
     */


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
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getPresent()
    {
        return $this->present;
    }

    /**
     * @param mixed $present
     */
    public function setPresent($present)
    {
        $this->present = $present;
    }

    /**
     * @return mixed
     */
    public function getAbscent()
    {
        return $this->abscent;
    }

    /**
     * @param mixed $abscent
     */
    public function setAbscent($abscent)
    {
        $this->abscent = $abscent;
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
}
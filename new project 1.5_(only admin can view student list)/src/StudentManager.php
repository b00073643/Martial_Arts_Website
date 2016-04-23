<?php
/**
 * Created by PhpStorm.
 * User: matt
 * Date: 20/02/2016
 * Time: 17:36
 */

namespace Itb;

/**
 * Class QuizManager - manage results of quizes
 * @package Itb
 */
class StudentManager
{
    /**
     * total questions correct
     * @var int
     */
    private $correct = 0;

    /**
     * total questions wrong
     * @var int
     */
    private $wrong = 0;

    /**
     * percentage requred to pass the test
     * @var int
     */
    private $passPercentage = 50;

    /**
     * get the total of questions that have been answered (correct + incorrect)
     * @return int
     */
    public function getTotalQuestionsAttempted()
    {
        return $this->correct + $this->wrong;
    }

    /**
     * get the number of questions correct
     * @return int
     */
    public function getTotalQuestionsCorrect()
    {
        return $this->correct;
    }

    /**
     * get the number of questions wrong
     * @return int
     */
    public function getTotalQuestionsWrong()
    {
        return $this->wrong;
    }

    /**
     * add one to the numner of questions correct
     */
    public function addOneToCorrectTotal()
    {
        $this->correct++;
    }

    /**
     * add one to the numner of questions wrong
     */
    public function addOneToWrongTotal()
    {
        $this->wrong++;
    }

    /**
     * calculate and return the percentage of questions correct
     * @return int
     */
    public function getPercentageQuestionsCorrect()
    {
        if ($this->getTotalQuestionsAttempted() < 1) {
            return 0;
        }

        $percent = (100 * $this->correct) / $this->getTotalQuestionsAttempted();
        return intval($percent);
    }

    /**
     * set the pass percentage
     * @param $p
     */
    public function setPassPercentage($p)
    {
        if (($p > 1) && ($p <= 100)) {
            $this->passPercentage = $p;
        }
    }

    /**
     * get the pass percentage
     * @return int
     */
    public function getPassPercentage()
    {
        return $this->passPercentage;
    }

    /**
     * return whether or not the quiz has been passeed
     * based on percentage correct and the pass percentage
     * @return bool
     */
    public function hasPassed()
    {
        if ($this->getPercentageQuestionsCorrect() >= $this->passPercentage) {
            return true;
        } else {
            return false;
        }
    }
}

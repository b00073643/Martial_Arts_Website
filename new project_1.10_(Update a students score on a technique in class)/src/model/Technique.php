<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 26/04/2016
 * Time: 00:19
 */

namespace Itb\Model;


use Mattsmithdev\PdoCrud\DatabaseTable;

class Technique extends DatabaseTable
{
    private $id;
    private $belt;
    private $name;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
    public function getBelt()
    {
        return $this->belt;
    }

    /**
     * @param mixed $belt
     */
    public function setBelt($belt)
    {
        $this->belt = $belt;
    }

}
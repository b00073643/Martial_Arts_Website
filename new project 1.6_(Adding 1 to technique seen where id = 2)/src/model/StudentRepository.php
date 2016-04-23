<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 17/04/2016
 * Time: 06:28
 */

namespace Itb\Model;


class StudentRepository extends DatabaseTable
{
public function __construct()
{
    parent::__construct('Student','students');
}
}
<?php

class Team
{
    protected $name;
    protected $members = [];

    /**
     * @param $name
     * @param array $members
     */
    public function __construct($name, $members = [])
    {
        $this->name = $name;
        $this->members = $members;
    }

    // Destructuring
    // Accepts a variable number of arguments which will be accessible as an array
    public static function start(...$params)
    {
        return new static(...$params);
    }

    public function name()
    {
        return $this->name;
    }

    public function members()
    {
        return $this->members;
    }

    public function add($name)
    {
        $this->members[] = $name;
    }

    public function cancel()
    {

    }

    public function manager()
    {

    }
}

class Member
{
    protected $name;

    /**
     * @param $name
     */

    // Now we have a dedicated place to put member specific information
    public function __construct($name)
    {
        $this->name = $name;
    }

    public function lastViewed()
    {

    }

}

$acme2 = Team::start('Acme', [
   // We no longer pass a parameter but instead a full object
    new Member('John Doe'),
    new Member('Jane Doe'),
]);

// We now get an array of member objects
var_dump($acme2->members());
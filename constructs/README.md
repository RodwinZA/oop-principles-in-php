# Object-Oriented Principles in PHP

---
## Section 1 | Constructs

---

### Objects

```php
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

// Instantiate a team using the `new` keyword, and
// Set initial members

$acme = new Team('Acme', [
    'John Doe',
    'Jane Doe'
]);

// Add more members using the `add` method
$acme->add('James Doe');

var_dump($acme->members());
```

We can also use a static constructor to instantiate a team. It is useful to make the code better reflect the way we speak in real life. For this example we can use the term `start` for a new team.

```php
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

    public static function start($name, $members = [])
    {
        return new static($name, $members);
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

// Instantiate a team using the `start` constructor, and
// Set initial members

$acme2 = Team::start('Acme', [
    'John Doe',
    'Jane Doe'
]);

// Add more members using the `add` method
$acme2->add('Frank Doe');

var_dump($acme2->members());
```

We can simplify the constructors by removing duplicated parameters. We achieve this by destructuring.

```php
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

$acme2 = Team::start('Acme', [
    'John Doe',
    'Jane Doe'
]);

$acme2->add('Frank Doe');

var_dump($acme2->members());
```

At the moment we are using a string to represent some member of our team. But what happens
when we need more information about each of these members, e.g. sign up date, email address, etc. In general, be suspicious of strings, because often, there is an object waiting to come out.

```php
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
```
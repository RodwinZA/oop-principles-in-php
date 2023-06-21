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

---

### Inheritance

```php
<?php

// Inheritance allows one object to acquire or inherit the traits of another object.
class CoffeeMaker
{
    public function brew()
    {
        var_dump('Brewing the coffee...');
    }
}

// We use the `extends` keyword to signify that the `SpecialtyCoffeeMaker`
// inherits all the traits from the `CoffeeMaker`.

// This means that the `brew` method can also be called on the `SpecialtyCoffeeMaker`.
class SpecialtyCoffeeMaker extends CoffeeMaker
{
    public function brewLatte()
    {
        var_dump('Brewing a latte...');
    }
}

(new SpecialtyCoffeeMaker())->brewLatte();
```

### Abstract Classes

Having classes that share similar methods can be written over and over again but this is not necessary. The example below would make things a lot difficult if we have e.g. 20 classes that make use of the same methods.

```php
<?php

class FirstThousandPoints
{
    public function name()
    {
        return 'First Thousand Points';
    }

    public function icon()
    {
        return 'first-thousand-points.png';
    }
    
    public function qualifier()
    {
        
    }
}

class FirstBestAnswer
{
    public function name()
    {
        return 'First Best Answer';
    }

    public function icon()
    {
        return 'first-best-answer.png';
    }

    public function qualifier()
    {

    }
}
```

An abstract class provides a template or base for any subclasses.

```php
<?php

// Parent Class
// This class should not be instantiated because it
// serves as the base class. This is possible by adding the `abstract`
// keyword

abstract class AchievementType
{
    public function name()
    {
        // Get the name of the class without any namespace prefix
        $class = (new ReflectionClass($this))->getShortName();

        // E.g. FirstThousandPoints => First Thousand Points
        // Replace every occurrence of a capital letter with a space
        // followed by the letter

        return trim(preg_replace('/[A-Z]/', ' $0', $class));
    }

    public function icon()
    {
        // Get the name from the `name` method
        // Replace every space with a '-' and append '.png' and make it lowercase

        return strtolower(str_replace(' ', '-', $this->name() . '.png'));

    }

    // `abstract`, meaning providing a 'signature'. That's why the method
    // has no body and why it will be required of any subclass to use.
    // Abstract methods needs specifics from the subclass calling it.
    abstract public function qualifier($user);
}

class FirstThousandPoints extends AchievementType
{

    public function qualifier($user)
    {

    }
}

class FirstBestAnswer extends AchievementType
{

    public function qualifier($user)
    {

    }
}

class ReachTop50 extends AchievementType
{

    public function qualifier($user)
    {

    }
}

// We always instantiate a subclass and not a parent class
$achievement = new ReachTop50();

echo $achievement->name();
echo "\n";
echo $achievement->icon();
```

### Handshakes and Interfaces

```php
<?php

// An interface is like a class without behaviour
interface Newsletter
{
    public function subscribe($email);
}

class CampaignMonitor implements Newsletter
{
    public function subscribe($email)
    {
        die('Subscribing with CampaignMonitor');
    }
}

class Drip implements Newsletter
{
    public function subscribe($email)
    {
        die('Subscribing with Drip');
    }
}

// The controller should only care about the `subscribe` method
// and not be bothered with the implementation, be it Drip or CampaignMonitor
class NewsletterSubscriptionsController
{

    public function store(Newsletter $newsletter)
    {
        $email = 'joe@example.com';
        $newsletter->subscribe($email);
    }

}

$controller = new NewsletterSubscriptionsController();
$controller->store(new CampaignMonitor());
```
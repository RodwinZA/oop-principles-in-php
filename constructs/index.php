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
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
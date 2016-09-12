<?php

namespace Opera\SampleSite;

use Opera\Component\Authentication\Authentication;
use Opera\Component\Authentication\AuthenticationInterface;
use Opera\Component\Authentication\User;
use Opera\Component\Authentication\UserInterface;
use Opera\Component\Authentication\UserProviderInterface;
use Opera\Component\Mail\BasicMailer;
use Opera\Component\Mail\Mailer;
use Opera\Component\Mail\MailerInterface;
use Opera\Component\WebApplication\Context;
use Opera\SampleSite\Model\BlogModel;
use Opera\SampleSite\Model\UserModel;
use Opera\SampleSite\Model\WhiteListModel;

/**
 * Class MyContainer
 *
 * This is a special class to initiate all your classes
 * that will be used around your project
 *
 * It is accessible within your controllers
 */
class MyContainer
{
    /**
     * @var MyContext
     */
    protected $context;

    public function __construct(Context $context)
    {
        $this->context = $context;
    }

    public function getMailer() : Mailer
    {
        return new Mailer(new BasicMailer());
    }

    public function getUserModel() : UserModel
    {
        return new UserModel($this->context->getDatabaseManager());
    }

    public function getBlogModel() : BlogModel
    {
        return new BlogModel($this->context->getDatabaseManager());
    }

    public function getWhiteListModel() : WhiteListModel
    {
         return new WhiteListModel($this->context->getDatabaseManager());
    }
}
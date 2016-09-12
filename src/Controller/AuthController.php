<?php
/**
 * OperaSampleSite
 * AuthController.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2016 All rights reserved
 * @license   MIT
 * @created   6-9-16
 * @version   1.0
 */

namespace Opera\SampleSite\Controller;


use Opera\Component\Authentication\User;
use Opera\Component\Authentication\UserNotFoundException;
use Opera\Component\Http\Response;
use Opera\Component\WebApplication\Message;
use Opera\SampleSite\MyController;

class AuthController extends MyController
{

    public function loginGet() : Response
    {
        return $this->render();
    }

    public function loginPost() : Response
    {
        $auth = $this->getContext()->getAuthentication();
        $post = $this->getRequest()->getPost();
        $user = new User($post->getString('username'), $post->getString('password'));

        try{
            if ($auth->authenticate($user)) {
                $this->addMessage(Message::TYPE_SUCCESS, 'Authorization succeeded');
                return $this->redirect();
            }
        }catch (UserNotFoundException $e){}
            $this->addMessage(Message::TYPE_DANGER, 'Provided login credentials were invalid');


        return $this->redirect('login');
    }

    public function logoutGet() : Response
    {
        $this->getSession()->remove('authenticatedUser');
        $this->addMessage(Message::TYPE_SUCCESS, 'You have been signed out');
        return $this->redirect();
    }

}
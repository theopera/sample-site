<?php
/**
 * OperaSampleSite
 * UserController.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2016 All rights reserved
 * @license   MIT
 * @created   11-9-16
 * @version   1.0
 */

namespace Opera\SampleSite\Controller;


use Opera\Component\Http\HttpException;
use Opera\Component\Http\Response;
use Opera\SampleSite\MyController;

class UserController extends MyController
{

    public function indexGet(string $username) : Response
    {
        $auth = $this->getContext()->getAuthentication();
        if (!$auth->isAuthenticated()) {
            throw HttpException::unauthorized('You need to be signed in to view this page');
        }


        $userModel = $this->getContainer()->getUserModel();
        $user = $userModel->findUser($username);

        return $this->render([
            'user' => $user,
        ]);
    }
}
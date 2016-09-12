<?php
/**
 * OperaSampleSite
 * UserModel.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2016 All rights reserved
 * @license   MIT
 * @created   6-9-16
 * @version   1.0
 */

namespace Opera\SampleSite\Model;


use Opera\Component\Authentication\UserInterface;
use Opera\Component\Authentication\UserNotFoundException;
use Opera\Component\Authentication\UserProviderInterface;
use Opera\Component\Database\AbstractModel;
use Opera\SampleSite\Entity\User;
use PDO;

class UserModel extends AbstractModel implements UserProviderInterface
{
    /**
     * @return User
     */
    public function getById(int $id)
    {
        $db = $this->getReader();

        $statement = $db->prepare('SELECT user_id, username FROM users WHERE user_id = :id');
        $result = $statement->bindValue('id', $id);

        if ($result) {
            return (new User())
                ->setUsername($result['username']);
        }

        return null;
    }


    public function findUser(string $username) : UserInterface
    {
        $db = $this->getReader();
        $statement = $db->prepare('SELECT * FROM users WHERE username = :username LIMIT 1');
        $statement->bindValue(':username', $username, PDO::PARAM_STR);
        if (!$statement->execute()) {
            throw UserNotFoundException::notFound($username);
        }

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if (empty($result)) {
            throw UserNotFoundException::notFound($username);
        }

        return (new User())
            ->setUsername($result['username'])
            ->setPassword($result['password'])
            ->setRole('user');

    }
}
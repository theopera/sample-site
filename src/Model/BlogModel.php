<?php
/**
 * OperaSampleSite
 * BlogModel.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2016 All rights reserved
 * @license   MIT
 * @created   6-9-16
 * @version   1.0
 */

namespace Opera\SampleSite\Model;


use Opera\Component\Database\AbstractModel;
use Opera\SampleSite\Entity\Blog;
use Opera\SampleSite\Entity\User;

class BlogModel extends AbstractModel
{


    /**
     * @return Blog[]
     */
    public function getAll()
    {
        $db = $this->getReader();

        $result = $db->query('SELECT blog_id, title, post, users.user_id, username FROM blogs 
                    JOIN users ON users.user_id = blogs.user_id')->fetchAll();

        $blogs = [];
        foreach ($result as $item) {

            $blogs[$item['blog_id']] = $this->createEntity($item);
        }

        return $blogs;
    }

    /**
     * @param int $id
     * @return Blog
     */
    public function getById(int $id)
    {
        $db = $this->getReader();
        $statement = $db->prepare('SELECT blog_id, title, post, users.user_id, username FROM blogs 
                    JOIN users ON users.user_id = blogs.user_id
                    WHERE blog_id = :id');

        $statement->bindValue('id', $id);
        $statement->execute();

        $result = $statement->fetch();
        if($result){
            return $this->createEntity($result);
        }

        return null;
    }

    /**
     * @param array $item
     * @return Blog
     */
    protected function createEntity(array $item) : Blog
    {
        $user = (new User())
            ->setId($item['user_id'])
            ->setUsername($item['username']);

        return (new Blog())
            ->setId($item['blog_id'])
            ->setTitle($item['title'])
            ->setPost($item['post'])
            ->setUser($user);
    }
}
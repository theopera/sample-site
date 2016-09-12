<?php
/**
 * OperaSampleSite
 * Blog.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2016 All rights reserved
 * @license   MIT
 * @created   10-9-16
 * @version   1.0
 */

namespace Opera\SampleSite\Entity;


class Blog
{

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $post;

    /**
     * @var User
     */
    protected $user;

    /**
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Blog
     */
    public function setId(int $id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    public function getUrlTitle() : string
    {
        return trim(preg_replace('/[^a-z0-9]+/', '-', strtolower($this->title)), '-');
    }

    /**
     * @param string $title
     * @return Blog
     */
    public function setTitle(string $title): Blog
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getPost(): string
    {
        return $this->post;
    }

    /**
     * @param string $post
     * @return Blog
     */
    public function setPost(string $post): Blog
    {
        $this->post = $post;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return Blog
     */
    public function setUser(User $user): Blog
    {
        $this->user = $user;
        return $this;
    }
}
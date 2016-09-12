<?php
/**
 * OperaSampleSite
 * BlogController.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2016 All rights reserved
 * @license   MIT
 * @created   6-9-16
 * @version   1.0
 */

namespace Opera\SampleSite\Controller;


use Opera\Component\Http\Response;
use Opera\SampleSite\MyController;

class BlogController extends MyController
{

    public function indexGet() : Response
    {
        $blogsModel = $this->getContainer()->getBlogModel();
        $blogs = $blogsModel->getAll();
        return $this->render([
            'blogs' => $blogs,
        ]);
    }

    public function postGet(int $id, string $title) : Response
    {
        $blogsModel = $this->getContainer()->getBlogModel();
        $blog = $blogsModel->getById($id);

        if ($blog->getUrlTitle() !== $title) {
            return $this->redirectUrl(sprintf('/blog/%d/%s', $blog->getId(), $blog->getUrlTitle()));
        }

        return $this->render([
            'blog' => $blog,
        ]);
    }
}
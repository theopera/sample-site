<?php

namespace Opera\SampleSite;


use Opera\Adapter\Twig\TwigAdapter;
use Opera\Component\Authentication\Authentication;
use Opera\Component\Authentication\AuthenticationInterface;
use Opera\Component\Database\DatabaseManager;
use Opera\Component\Database\DatabaseManagerInterface;
use Opera\Component\Database\SqliteConnection;
use Opera\Component\Http\Request;
use Opera\Component\Http\Response;
use Opera\Component\Template\RenderInterface;
use Opera\Component\WebApplication\Context;
use Opera\Component\Http\Middleware\MiddlewareCollectionInterface;
use Opera\Component\WebApplication\RouteCollection;
use Opera\SampleSite\Middleware\AuthMiddleware;
use Opera\SampleSite\Middleware\FirewallMiddleware;
use Opera\SampleSite\Model\UserModel;

class MyContext extends Context
{
    /**
     * @var DatabaseManagerInterface
     */
    protected $databaseManager;

    /**
     * @var MyContainer
     */
    protected $container;

    public function getControllerNamespace() : string
    {
        return 'Opera\\SampleSite\\Controller\\';
    }

    public function getViewDirectory() : string
    {
        return __DIR__ . '/view';
    }

    public function getTemplateEngine() : RenderInterface
    {
        if ($this->render === null) {
            $adapter = new TwigAdapter($this->getViewDirectory());
            if ($this->getEnvironment() === 'development') {
                $twig = $adapter->getTwig();
                $twig->enableDebug();
                $twig->addExtension(new \Twig_Extension_Debug());
            }

            $this->render = $adapter;
        }

        return $this->render;
    }

    public function getRouteCollection() : RouteCollection
    {
        $collection = (new RouteCollection($this->getControllerNamespace()))
            ->addRoute('/contact', 'default', 'contact')
            ->addRoute('/contact', 'default', 'contact', Request::METHOD_POST)
            ->addRoute('/logout', 'auth', 'logout')
            ->addRoute('/login', 'auth', 'login')
            ->addRoute('/login', 'auth', 'login', Request::METHOD_POST)
            ->addRoute('/blog/[i:id]/[a:title]', 'blog', 'post')
            ->addRoute('/user/[a:username]', 'user');

        return $collection;
    }

    public function getDatabaseManager() : DatabaseManagerInterface
    {
        if ($this->databaseManager === null) {
            $this->databaseManager = new DatabaseManager();
            $this->databaseManager->addConnection(new SqliteConnection(__DIR__ . '/../storage.sqlite', 3));
        }

        return $this->databaseManager;
    }

    public function getMiddlewareCollection(MiddlewareCollectionInterface $collection) : MiddlewareCollectionInterface
    {
        return $collection
            ->add(new FirewallMiddleware($this->getContainer()->getWhiteListModel()))
            ->add(new AuthMiddleware($this));
    }

    public function getAuthentication() : AuthenticationInterface
    {
        return new Authentication(
            new UserModel($this->getDatabaseManager()),
            $this->getSessionManager()->getSession(session_id())
        );
    }

    public function getContainer() : MyContainer
    {
        if ($this->container === null) {
            $this->container = new MyContainer($this);
        }

        return $this->container;
    }


}
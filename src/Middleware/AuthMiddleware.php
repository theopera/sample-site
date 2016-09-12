<?php
/**
 * OperaSampleSite
 * AuthMiddleware.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2016 All rights reserved
 * @license   MIT
 * @created   3-9-16
 * @version   1.0
 */

namespace Opera\SampleSite\Middleware;


use Opera\Component\Http\HttpException;
use Opera\Component\Http\Request;
use Opera\Component\Http\RequestInterface;
use Opera\Component\Http\Response;
use Opera\Component\Http\ResponseInterface;
use Opera\Component\Http\Middleware\MiddlewareCollectionInterface;
use Opera\Component\Http\Middleware\MiddlewareInterface;
use Opera\Component\WebApplication\Context;

class AuthMiddleware implements MiddlewareInterface
{

    /**
     * @var Context
     */
    private $context;

    public function __construct(Context $context)
    {
        $this->context = $context;
    }

    public function handle(MiddlewareCollectionInterface $collection, RequestInterface $request) : ResponseInterface
    {
        $auth = $this->context->getAuthentication();

        if (strpos($request->getUri(), '/login') !== 0  && !$auth->isAuthenticated()) {
            //return Response::redirect('/login');
        }


        return $collection->next();
    }
}
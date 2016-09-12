<?php
/**
 * OperaSampleSite
 * FirewallMiddleware.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2016 All rights reserved
 * @license   MIT
 * @created   3-9-16
 * @version   1.0
 */

namespace Opera\SampleSite\Middleware;

use Opera\Component\Http\HttpException;
use Opera\Component\Http\RequestInterface;
use Opera\Component\Http\ResponseInterface;
use Opera\Component\Http\Middleware\MiddlewareCollectionInterface;
use Opera\Component\Http\Middleware\MiddlewareInterface;
use Opera\SampleSite\Model\WhiteListModel;

class FirewallMiddleware implements MiddlewareInterface
{

    /**
     * @var WhiteListModel
     */
    private $whiteListModel;

    public function __construct(WhiteListModel $whiteListModel)
    {
        $this->whiteListModel = $whiteListModel;
    }

    public function handle(MiddlewareCollectionInterface $collection, RequestInterface $request) : ResponseInterface
    {
        if (!$this->whiteListModel->isWhiteListed($request->getIp())) {
            throw HttpException::forbidded(
                'Sorry you are blocked by our firewall, if you are certain that this is an error, please contact us.'
            );
        }

        return $collection->next();
    }
}
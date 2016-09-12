The Opera Sample Site
=====================
The idea behind this project is to demonstrate the power and capabilities of The Opera Framework. 
As you might noticed, this project is still in alpha phase.

Currently this demo demonstrates the following features:

 - Database handling
 - Session handling
 - Authorization
 - Middleware, like a firewall, caching mechanism
 - Routing (e.g. /blog/12/title -> BlogController::postGet(int $id, string $title))
 - Sending mail
 - **But the framework has a lot more to offer...**


Installation
------------
Clone this this project and run `composer install`.
We will use the PHP builtin web server to serve this application.
 
 `php -S 0.0.0.0:8080 -t public`
 
 *Note: thanks to the builtin firewall, only requests from localhost are allowed*


 
 
Contributing
------------
I'm always open for pull requests.

License & Copyright
-------------------
The Opera Sample Site is released under the MIT license, for more details see the LICENSE file.

Copyright 2016 Marc Heuker of Hoek

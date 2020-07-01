<?php
use Slim\App;
use App\Middleware\ContentTypeMiddleware;


return function (App $app) {

        $app->addBodyParsingMiddleware();

        $app->add(new ContentTypeMiddleware());
        
    
};
<?php
namespace App\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use App\Utils\Auth;

class JwtMiddleware
{
    /**
     * Example middleware invokable class
     *
     * @param  ServerRequest  $request PSR-7 request
     * @param  RequestHandler $handler PSR-15 request handler
     *
     * @return Response
     */
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $headers = getallheaders();
        $valid = Auth::validTokenFromHeaders($headers);

        if(!$valid){
            throw new \Slim\Exception\HttpForbiddenException($request);
            return $response->whithStatus(401);
        }
        else{

            $response = $handler->handle($request);
            $response->getBody();
            return $response;
        }
    }
}

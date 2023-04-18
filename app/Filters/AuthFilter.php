<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthFilter implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $key = getenv('CI_JWT_KEY');
        $jwt_algo = getenv('CI_JWT_ALGO');
        $header = $request->getHeaderLine('Authorization');
        $token = null;

        if (! empty($header)) {
            if (preg_match('/Bearer\s(\S+)/', $header, $matches)) {
                $token = $matches[1];
            }
        }

        // check if token is null or empty
        if (is_null($token) || empty($token)) {
            return response()
            ->setJSON(["message" => 'Access denied'])
            ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }

        try {
            $decode = JWT::decode($token, new Key($key, $jwt_algo));
            // $user = (new User)->where('email', $decode->email)->first();
            // $request->user = $user;
        } catch (Exception $exception) {
            log_message("error", $exception);
            return response()
            ->setJSON(['msg' => 'Invalid Token!'])
            ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }

        return $request;
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}

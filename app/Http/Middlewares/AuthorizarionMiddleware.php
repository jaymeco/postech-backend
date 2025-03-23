<?php

namespace App\Http\Middlewares;

use App\Exceptions\ApplicationException;
use App\Exceptions\AuthException;
use Closure;
use Core\Application\Contracts\Services\AuthService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorizarionMiddleware
{
    public function __construct(
        private readonly AuthService $authService,
    ) {}

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->headers->get('Authorization');

        try {
            if (!is_null($token)) {
                $this->authService->authorizate($token);
            }
        } catch (\Throwable $th) {
            throw AuthException::notAuthorized();
        }

        return $next($request);
    }
}

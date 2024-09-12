<?php

namespace App\Exceptions;

use App\Enums\ResponseCode;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Exceptions\RoleAlreadyExists;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e): Response|JsonResponse|SymfonyResponse
    {
        if ($request->is('api/*') && (false === $e instanceof RestfulApiException)) {
            $e = $this->mapToRestfulApiException($request, $e);
        }

        return parent::render($request, $e);
    }

    private function mapToRestfulApiException(Request $request, Throwable $e): RestfulApiException|Throwable
    {
        if ($e instanceof ModelNotFoundException) {
            return new RestfulApiException(ResponseCode::ERR_ENTITY_NOT_FOUND, ResponseCode::ERR_ENTITY_NOT_FOUND->message(), previous: $e);
        }

        if ($e instanceof ValidationException) {
            return new RestfulApiException(ResponseCode::ERR_VALIDATION, $e->getMessage(), $e->errors(), previous: $e);
        }

        if ($e instanceof BadRequestException) {
            return new RestfulApiException(ResponseCode::ERR_VALIDATION, $e->getMessage(), $e->getMessage(), previous: $e);
        }

        if ($e instanceof RoleAlreadyExists) {
            return new RestfulApiException(ResponseCode::ERR_VALIDATION, $e->getMessage(), previous: $e);
        }

//        if ($e instanceof OAuthServerException || $e instanceof AuthenticationException) {
//            return new MaasyaException(ResponseCode::ERR_AUTHENTICATION, $e->getMessage(), null, $e);
//        }

        if ($e instanceof AuthenticationException) {
            return new RestfulApiException(ResponseCode::ERR_AUTHENTICATION, $e->getMessage(), null, $e);
        }

        if ($e instanceof NotFoundHttpException) {
            return new RestfulApiException(ResponseCode::ERR_ROUTE_NOT_FOUND, $e->getMessage(), null, $e);
        }

        if ($e instanceof AuthorizationException || $e instanceof UnauthorizedException) {
            return new RestfulApiException(ResponseCode::ERR_ACTION_UNAUTHORIZED, $e->getMessage(), null, $e);
        }

        if (config('app.debug')) {
            return $e;
        }

        return new RestfulApiException(
            rc: ResponseCode::ERR_UNKNOWN,
            data: [
                'base_url' => $request->getBaseUrl(),
                'path' => $request->getUri(),
                'origin' => $request->ip(),
                'method' => $request->getMethod(),
            ],
            previous: $e
        );
    }
}

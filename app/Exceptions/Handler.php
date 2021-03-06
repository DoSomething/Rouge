<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use League\Glide\Filesystem\FileNotFoundException as GlideNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exceptionxception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */
    public function render($request, Exception $exception)
    {
        // If Intervention can't parse a file (corrupted or wrong type), return 422.
        // @TODO: Handle this with a validation rule on our v3 routes.
        if (
            $exception instanceof
            \Intervention\Image\Exception\NotReadableException
        ) {
            abort(422, 'Invalid image provided.');
        }

        // Re-cast specific exceptions or uniquely render them:
        if ($exception instanceof GlideNotFoundException) {
            $exception = new NotFoundHttpException(
                'That image could not be found.',
            );
        } elseif ($exception instanceof ModelNotFoundException) {
            $exception = new NotFoundHttpException(
                'That resource could not be found.',
            );
        }

        return parent::render($request, $exception);
    }

    /**
     * Get the default context variables for logging exceptions.
     *
     * @return array
     */
    protected function context()
    {
        // We handle adding context in AppServiceProvider, and specifically
        // want to disable Laravel's default behavior of appending email here.
        return [];
    }
}

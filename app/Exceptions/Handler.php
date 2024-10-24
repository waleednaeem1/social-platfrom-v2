<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Mail;
use Auth;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */


    public function render($request, Throwable $e)
    {
        if($e instanceof NotFoundHttpException)
        {
            return response()->view('pages.error', [], 404);
        }
        return parent::render($request, $e);
        
    }

    public function register()
    {


        $this->reportable(function (Throwable $e) {
            // get error message
            $error_message = $e->getMessage();

            // get file
            $error_file = $e->getFile();

            // get line number
            $error_line = $e->getLine();

            // get method, GET or POST
            $method = request()->method();

            // get full URL including query string
            $full_url = request()->fullUrl();

            // get route name
            $route = "";

            // get list of all middlewares attached to that route
            $middlewares = "";

            // data with the request
            $inputs = "";
            if (request()->route() != null)
            {
                $route = "uri: " . request()->route()->getName();
                $middlewares = json_encode(request()->route()->gatherMiddleware());
                $inputs = json_encode(request()->all());
            }

            // get IP address of user
            $ip = request()->ip();

            // get user browser or request source
            $user_agent = request()->userAgent();

            // create email body
            $html = $error_message . "\n\n";
            $html .= "File: " . $error_file . "\n\n";
            $html .= "Line: " . $error_line . "\n\n";
            $html .= "Inputs: " . $inputs . "\n\n";
            $html .= "Method: " . $method . "\n\n";
            $html .= "Full URL: " . $full_url . "\n\n";
            $html .= "Route: " . $route . "\n\n";
            $html .= "Middlewares: " . $middlewares . "\n\n";
            $html .= "IP: " . $ip . "\n\n";
            $html .= "User Agent: " . $user_agent . "\n\n";
            // for testing purpose only
            // Auth::loginUsingid(1);

            // check if user is logged in
            // if (Auth::check())
            // {
            //     // get email of user that faced this error
            //     $html .= "User: " . Auth::user()->email;
            // }

            // subject of email
            // $subject = "Internal Server Error";

            // send an email
            // Mail::raw($html, function ($message) use ($subject) {
            //     // developer email
            //     $message->to("uzair.gmit@gmail.com")
            //         ->subject($subject);
            // });
        });

    }
}

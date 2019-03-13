<?php

namespace App\Exceptions;

use Exception;

class UnauthorizedException extends Exception
{
    /**
     * Render the exception as an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return redirect('home')->with('alert.danger', 'You are not authorized to perform this action');
    }
}

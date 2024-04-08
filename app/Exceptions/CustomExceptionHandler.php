<?php

namespace App\Exceptions;


use Brian2694\Toastr\Facades\Toastr;
use Exception;

class CustomExceptionHandler extends Exception
{
    public function render($request, Exception $exception)
    {
        if ($this->isHttpException($exception)) {
            if ($exception->getStatusCode() == 404) {
                Toastr::error('Halaman tidak ditemukan', 'Error 404');
                return redirect()->route('home');
            }
        }

        return parent::render($request, $exception);
    }
}

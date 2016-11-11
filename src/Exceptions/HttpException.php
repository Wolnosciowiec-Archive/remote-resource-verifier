<?php

namespace Exceptions;

class HttpException extends \Exception
{
    const NOT_FOUND     = 404;
    const ACCESS_DENIED = 403;
    const SERVER_ERROR  = 500;
}
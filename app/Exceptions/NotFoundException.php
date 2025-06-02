<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class NotFoundException extends HttpException
{
    public function __construct(string $resource = 'Recurso')
    {
        parent::__construct(404, "$resource não encontrado.");
    }
}

<?php

declare(strict_types=1);

namespace Ciebit\Leads\Exceptions;

use Ciebit\Leads\Exceptions\Exception;
use Exception as ExceptionNative;

final class Storage extends ExceptionNative implements Exception
{
    public function __construct(string $message, int $code)
    {
        parent::__construct($message, $code);
    }
}

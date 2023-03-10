<?php

declare(strict_types=1);

namespace Src\BackOffice\MedicalService\Domain\Exception;

use Exception;

class MedicalServiceNotFoundException extends Exception
{
    public function __construct()
    {
        parent::__construct(
            'Medical Service Not Found',
            404
        );
    }
}

<?php

namespace Src\shared\Infrastructure\Response\Rest;

use Src\shared\Domain\Response\ResponseData;
use Src\shared\Domain\Response\ResponseMessage;
use Src\shared\Domain\Response\ResponseSuccess;

class ResponseDataBuilder
{
    public function build(
        string $message,
        bool $success,
        array|null $data = null
    ): ResponseData {
        if (empty($data)) {
            return ResponseData::createFromMessageAndSuccess(
                ResponseMessage::create($message),
                ResponseSuccess::create($success)
            );
        }

        return ResponseData::create(
            ResponseMessage::create($message),
            ResponseSuccess::create($success),
            $data
        );
    }
}

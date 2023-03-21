<?php

declare(strict_types=1);

namespace Src\shared\Domain\Response;

class Response
{
    private function __construct(
        private readonly ResponseCode $code,
        private readonly ResponseData $data
    ) {
    }

    public static function create(ResponseCode $code, ResponseData $data): self
    {
        return new static($code, $data);
    }

    public function code(): ResponseCode
    {
        return $this->code;
    }

    public function data(): ResponseData
    {
        return $this->data;
    }
}

<?php

namespace Src\shared\Infrastructure\Mail\MailTrap;

use Src\shared\Domain\HttpClient\Contract\HttpClientContract;
use Src\shared\Domain\Mail\Contract\MailerContract;
use Src\shared\Domain\Mail\DomainMail;
use Src\shared\Domain\Mail\Exception\MailCanNotBeSendException;
use Throwable;

class MailtrapMailer implements MailerContract
{
    public function __construct(
        private readonly HttpClientContract $client,
        private readonly Mailtrap $mailtrap
    ) {
    }

    public function send(DomainMail $mail): void
    {
        try {
            $this->client
                ->asJson()
                ->withToken($this->mailtrap->apiToken())
                ->post($this->mailtrap->apiUrl(), $this->mailtrap->body($mail));
        } catch (Throwable $throwable) {
            throw new MailCanNotBeSendException($throwable->getMessage());
        }
    }
}

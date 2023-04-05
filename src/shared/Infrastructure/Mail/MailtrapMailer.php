<?php

namespace Src\shared\Infrastructure\Mail;

use Src\shared\Domain\App\ApplicationContract;
use Src\shared\Domain\Config\ConfigContract;
use Src\shared\Domain\HttpClient\Contract\HttpClientContract;
use Src\shared\Domain\HttpClient\Exception\HttpClientException;
use Src\shared\Domain\Mail\Contract\MailerContract;
use Src\shared\Domain\Mail\DomainMail;
use Src\shared\Domain\Mail\Exception\MailCanNotBeSendException;
use Src\shared\Domain\Mail\MailContentType;
use Throwable;

class MailtrapMailer implements MailerContract
{
    private string $configKey = 'services.mailtrap.';

    public function __construct(
        private readonly ApplicationContract $app,
        private readonly ConfigContract $config,
        private readonly HttpClientContract $client
    ) {
    }

    public function send(DomainMail $mail): void
    {
        $environment = $this->app->environment();
        $configSettings = $this->config->get($this->configKey . $environment);
        $configSettings['api_url'] = "{$configSettings['api_url']}send";
        if (in_array($environment, ['local', 'testing'])) {
            $configSettings['api_url'] .= "/{$configSettings['inbox_id']}/test";
        }

        try {
            $this->client
                ->asJson()
                ->withToken($configSettings['api_token'])
                ->post($configSettings['api_url'], $this->payload($mail));
        } catch (Throwable $throwable) {
            throw new MailCanNotBeSendException($throwable->getMessage());
        }
    }

    private function payload(DomainMail $mail): array
    {
        $payload = [
            'to' => [
                $mail->to()->toArray()
            ],
            'from' => $mail->from()->toArray(),
            'subject' => $mail->subject()->value(),
            'text' => $mail->content()[MailContentType::TEXT_PLAIN]->value(),
        ];
        if (!empty($mail->content()[MailContentType::TEXT_HTML])) {
            $payload['html'] = $mail->content()[MailContentType::TEXT_HTML]->value();
        }

        return $payload;
    }
}

<?php

declare(strict_types=1);

namespace Src\shared\Infrastructure\Mail\MailTrap;

use Src\shared\Domain\App\ApplicationContract;
use Src\shared\Domain\Config\ConfigContract;
use Src\shared\Domain\Mail\DomainMail;
use Src\shared\Domain\Mail\MailContentType;
use Src\shared\Infrastructure\Mail\MailTrap\Exception\MailtrapRequiredTextBodyException;

class Mailtrap
{
    private readonly string $configFileKey;
    private array $configSettings;

    private readonly string $environment;

    public function __construct(private readonly ApplicationContract $app, private readonly ConfigContract $config)
    {
        $this->configFileKey = 'services.mailtrap.';
        $this->environment = $this->app->environment();
        $this->configSettings = $this->config->get($this->configFileKey . $this->environment);
    }

    public function apiUrl(): string
    {
        if (in_array($this->environment, ['local', 'testing'])) {
            return "{$this->configSettings['api_url']}send/{$this->configSettings['inbox_id']}";
        }
        return "{$this->configSettings['api_url']}send";
    }

    public function apiToken(): string
    {
        return $this->configSettings['api_token'];
    }

    public function body(DomainMail $mail): array
    {
        if (empty($mail->getContentByType(MailContentType::TEXT_PLAIN))) {
            throw new MailtrapRequiredTextBodyException();
        }
        if (!empty($mail->getContentByType(MailContentType::TEXT_HTML))) {
            return [
                'to' => [
                    $mail->to()->toArray()
                ],
                'from' => $mail->from()->toArray(),
                'subject' => $mail->subject()->value(),
                'text' => $mail->getContentByType(MailContentType::TEXT_PLAIN)->value(),
                'html' => $mail->getContentByType(MailContentType::TEXT_PLAIN)->value(),
            ];
        }
        return [
            'to' => [
                $mail->to()->toArray()
            ],
            'from' => $mail->from()->toArray(),
            'subject' => $mail->subject()->value(),
            'text' => $mail->content()[MailContentType::TEXT_PLAIN]->value(),
        ];
    }
}

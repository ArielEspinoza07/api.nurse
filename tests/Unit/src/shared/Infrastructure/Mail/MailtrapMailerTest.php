<?php

namespace Tests\Unit\src\shared\Infrastructure\Mail;

use Mockery;
use Src\shared\Domain\App\ApplicationContract;
use Src\shared\Domain\Config\ConfigContract;
use Src\shared\Domain\HttpClient\Contract\HttpClientContract;
use Src\shared\Domain\HttpClient\HttpClientResponse;
use Src\shared\Domain\HttpClient\HttpClientResponseBody;
use Src\shared\Domain\HttpClient\HttpClientResponseStatus;
use Src\shared\Domain\Mail\Exception\MailCanNotBeSendException;
use Src\shared\Domain\Mail\MailContentType;
use Src\shared\Infrastructure\Mail\MailtrapMailer;

class MailtrapMailerTest extends MailTestBase
{
    public function test_mailtrap_mailer_send_mail(): void
    {
        $environment = app()->environment();

        $mailTrapServiceConfigFileKey = "services.mailtrap.{$environment}";

        $configSettings = config($mailTrapServiceConfigFileKey);

        $apiUrl = "{$configSettings['api_url']}send";
        if (in_array($environment, ['local', 'testing'])) {
            $apiUrl .= "/{$configSettings['inbox_id']}";
        }

        $domainMail = $this->createDomainMail();

        $payload = [
            'to' => [
                $domainMail->to()->toArray()
            ],
            'from' => $domainMail->from()->toArray(),
            'subject' => $domainMail->subject()->value(),
            'text' => $domainMail->content()[MailContentType::TEXT_PLAIN]->value(),
            'html' => $domainMail->content()[MailContentType::TEXT_HTML]->value(),
        ];

        $fakeResponseBody = '{"success":true,"message_ids":["3382240670"]}';

        $app = Mockery::mock(ApplicationContract::class);
        $this->app->instance(MailtrapMailer::class, $app);

        $app->shouldReceive('environment')
            ->once()
            ->withNoArgs()
            ->andReturn($environment);

        $config = Mockery::mock(ConfigContract::class);
        $this->app->instance(MailtrapMailer::class, $config);

        $config->shouldReceive('get')
            ->once()
            ->with(
                Mockery::on(function (string $key) use ($mailTrapServiceConfigFileKey) {
                    return $key === $mailTrapServiceConfigFileKey;
                }),
            )
            ->andReturn($configSettings);

        $client = Mockery::mock(HttpClientContract::class);
        $this->app->instance(MailtrapMailer::class, $client);

        $client->shouldReceive('asJson')
            ->once()
            ->withNoArgs()
            ->andReturnSelf();

        $client->shouldReceive('withToken')
            ->once()
            ->with(
                Mockery::on(function (string $token) use ($configSettings) {
                    return $token === $configSettings['api_token'];
                }),
            )
            ->andReturnSelf();

        $client->shouldReceive('post')
            ->once()
            ->with(
                Mockery::on(function (string $url) use ($apiUrl) {
                    return $url === $apiUrl;
                }),
                Mockery::on(function (array $data) use ($payload) {
                    return count($data) === count($payload);
                }),
            )
            ->andReturn(
                HttpClientResponse::create(
                    HttpClientResponseStatus::create(200),
                    HttpClientResponseBody::create($fakeResponseBody)
                )
            );

        (new MailtrapMailer($app, $config, $client))->send($domainMail);
    }

    public function test_mailtrap_mailer_throws_exception(): void
    {

        $this->expectException(MailCanNotBeSendException::class);

        $environment = app()->environment();

        $mailTrapServiceConfigFileKey = "services.mailtrap.{$environment}";

        $configSettings = config($mailTrapServiceConfigFileKey);

        $apiUrl = "{$configSettings['api_url']}send";
        if (in_array($environment, ['local', 'testing'])) {
            $apiUrl .= "/{$configSettings['inbox_id']}/test";
        }

        $domainMail = $this->createDomainMail();

        $payload = [
            'to' => [
                $domainMail->to()->toArray()
            ],
            'from' => $domainMail->from()->toArray(),
            'subject' => $domainMail->subject()->value(),
            'text' => $domainMail->content()[MailContentType::TEXT_PLAIN]->value(),
            'html' => $domainMail->content()[MailContentType::TEXT_HTML]->value(),
        ];

        $app = Mockery::mock(ApplicationContract::class);
        $this->app->instance(MailtrapMailer::class, $app);

        $app->shouldReceive('environment')
            ->once()
            ->withNoArgs()
            ->andReturn($environment);

        $config = Mockery::mock(ConfigContract::class);
        $this->app->instance(MailtrapMailer::class, $config);

        $config->shouldReceive('get')
            ->once()
            ->with(
                Mockery::on(function (string $key) use ($mailTrapServiceConfigFileKey) {
                    return $key === $mailTrapServiceConfigFileKey;
                }),
            )
            ->andReturn($configSettings);

        $client = Mockery::mock(HttpClientContract::class);
        $this->app->instance(MailtrapMailer::class, $client);

        $client->shouldReceive('asJson')
            ->once()
            ->withNoArgs()
            ->andReturnSelf();

        $client->shouldReceive('withToken')
            ->once()
            ->with(
                Mockery::on(function (string $token) use ($configSettings) {
                    return $token === $configSettings['api_token'];
                }),
            )
            ->andReturnSelf();

        $client->shouldReceive('post')
            ->once()
            ->with(
                Mockery::on(function (string $url) use ($apiUrl) {
                    return $url === $apiUrl;
                }),
                Mockery::on(function (array $data) use ($payload) {
                    return count($data) === count($payload);
                }),
            )
            ->andThrow(MailCanNotBeSendException::class);

        (new MailtrapMailer($app, $config, $client))->send($domainMail);
    }
}

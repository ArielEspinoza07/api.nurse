<?php

namespace Tests\Unit\src\shared\Infrastructure\Mail;

use Illuminate\Foundation\Testing\WithFaker;
use Src\shared\Domain\EmailAddress;
use Src\shared\Domain\Mail\DomainMail;
use Src\shared\Domain\Mail\MailContent;
use Src\shared\Domain\Mail\MailContentType;
use Src\shared\Domain\Mail\MailFrom;
use Src\shared\Domain\Mail\MailFromName;
use Src\shared\Domain\Mail\MailSubject;
use Src\shared\Domain\Mail\MailTo;
use Tests\TestCase;

class MailTestBase extends TestCase
{
    use WithFaker;

    protected function createDomainMail(): DomainMail
    {
        $mail = DomainMail::create(
            MailFrom::create(
                EmailAddress::create($this->faker->email),
                MailFromName::create($this->faker->name)
            ),
            MailSubject::create('Welcome email'),
            MailTo::create(
                EmailAddress::create($this->faker->email),
                MailFromName::create($this->faker->name)
            )
        );

        $verificationUrl = $this->faker->url;

        $textPlain = view('emails.auth.verification-email.text-plain', ['url' => $verificationUrl])->render();
        $mail->addContent(
            MailContent::create(MailContentType::create(MailContentType::TEXT_PLAIN), $textPlain)
        );

        $textHtml = view('emails.auth.verification-email.text-html', ['url' => $verificationUrl])->render();
        $mail->addContent(
            MailContent::create(MailContentType::create(MailContentType::TEXT_HTML), $textHtml)
        );

        return $mail;
    }
}

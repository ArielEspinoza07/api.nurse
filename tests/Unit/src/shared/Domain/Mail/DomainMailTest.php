<?php

namespace Tests\Unit\src\shared\Domain\Mail;

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

class DomainMailTest extends TestCase
{
    use WithFaker;

    public function test_return_mail_instance(): void
    {
        $domainMail = DomainMail::create(
            MailFrom::create(
                EmailAddress::create($this->faker->email),
                MailFromName::create($this->faker->name)
            ),
            MailSubject::create('Welcome email'),
            MailTo::create(EmailAddress::create($this->faker->email))
        );

        $this->assertNotNull($domainMail);
        $this->assertInstanceOf(DomainMail::class, $domainMail);

        $this->assertNotNull($domainMail->from());
        $this->assertInstanceOf(MailFrom::class, $domainMail->from());
        $this->assertNotNull($domainMail->from()->address());
        $this->assertInstanceOf(EmailAddress::class, $domainMail->from()->address());
        $this->assertNotNull($domainMail->from()->name());
        $this->assertInstanceOf(MailFromName::class, $domainMail->from()->name());

        $this->assertNotNull($domainMail->to());
        $this->assertInstanceOf(MailFrom::class, $domainMail->from());
        $this->assertNotNull($domainMail->to()->address());
        $this->assertInstanceOf(EmailAddress::class, $domainMail->to()->address());
        $this->assertNull($domainMail->to()->name());

        $this->assertIsArray($domainMail->content());
        $this->assertEmpty($domainMail->content());

        $verificationUrl = $this->faker->url;

        $textPlain = view('emails.auth.verification-email.text-plain', ['url' => $verificationUrl])->render();

        $domainMail->addContent(
            MailContent::create(MailContentType::create(MailContentType::TEXT_PLAIN), $textPlain)
        );

        $this->assertNotEmpty($domainMail->content());
        $this->assertCount(1, $domainMail->content());

        $textHtml = view('emails.auth.verification-email.text-html', ['url' => $verificationUrl])->render();

        $domainMail->addContent(
            MailContent::create(MailContentType::create(MailContentType::TEXT_HTML), $textHtml)
        );

        $this->assertCount(2, $domainMail->content());
    }
}

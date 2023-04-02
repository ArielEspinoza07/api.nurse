<?php

declare(strict_types=1);

namespace Src\shared\Domain\Mail;

class DomainMail
{
    private MailFrom $mailFrom;

    private function __construct(
        private readonly MailFrom $from,
        private readonly MailSubject $subject,
        private readonly MailTo $to,
        private array $content = []
    ) {
    }

    public static function create(MailFrom $from, MailSubject $subject, MailTo $to): DomainMail
    {
        return new static($from, $subject, $to);
    }

    public function from(): MailFrom
    {
        return $this->from;
    }

    public function subject(): MailSubject
    {
        return $this->subject;
    }

    public function to(): MailTo
    {
        return $this->to;
    }

    public function content(): array
    {
        return $this->content;
    }

    public function addContent(MailContent $content): void
    {
        $this->content[] = $content;
    }
}

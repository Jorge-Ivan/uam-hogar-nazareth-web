<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Mail\ContactFormMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

final class SendContactEmail implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries = 3;

    /**
     * Settings values are captured at dispatch time so the job uses
     * the correct configuration even if settings change before it runs.
     *
     * @param array{name: string, email: string, phone: string|null, message: string} $formData
     */
    public function __construct(
        public readonly array $formData,
        public readonly string $mailTo,
        public readonly string $fromName,
        public readonly string $fromAddress,
    ) {}

    public function handle(): void
    {
        Mail::to($this->mailTo)->send(
            new ContactFormMail($this->formData, $this->fromName, $this->fromAddress)
        );
    }
}

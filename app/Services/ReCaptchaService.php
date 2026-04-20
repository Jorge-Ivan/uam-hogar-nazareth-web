<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Http;

final class ReCaptchaService
{
    public function __construct(
        private readonly string $secretKey,
        private readonly float $minScore,
    ) {}

    public function verify(string $token): bool
    {
        if (empty($this->secretKey)) {
            return true;
        }

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret'   => $this->secretKey,
            'response' => $token,
        ]);

        $data = $response->json();

        return ($data['success'] ?? false)
            && ($data['score'] ?? 0.0) >= $this->minScore;
    }
}

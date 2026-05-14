<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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

        if (empty($token)) {
            Log::warning('reCAPTCHA: token vacío recibido');
            return false;
        }

        try {
            $response = Http::timeout(5)->asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret'   => $this->secretKey,
                'response' => $token,
            ]);

            $data = $response->json();

            return ($data['success'] ?? false)
                && ($data['score'] ?? 0.0) >= $this->minScore;
        } catch (\Throwable $e) {
            Log::error('reCAPTCHA: error al contactar Google', [
                'message' => $e->getMessage(),
            ]);

            return false;
        }
    }
}

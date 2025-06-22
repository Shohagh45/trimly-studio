<?php

namespace Service;

class JWTService
{
    public static function createJWT(array $payload, string $secret): string
    {
        $header = [
            'alg' => 'HS256',
            'typ' => 'JWT'
        ];

        $base64UrlHeader = rtrim(strtr(base64_encode(json_encode($header)), '+/', '-_'), '=');
        $base64UrlPayload = rtrim(strtr(base64_encode(json_encode($payload)), '+/', '-_'), '=');

        $signature = hash_hmac(
            'sha256',
            "$base64UrlHeader.$base64UrlPayload",
            $secret,
            true
        );

        $base64UrlSignature = rtrim(strtr(base64_encode($signature), '+/', '-_'), '=');

        return "$base64UrlHeader.$base64UrlPayload.$base64UrlSignature";
    }

    public static function verifyJWT(string $token, string $secret): ?array
    {
        $parts = explode('.', $token);

        if (count($parts) !== 3) {
            return null;
        }

        [$headerB64, $payloadB64, $signatureB64] = $parts;


        $expectedSignature = hash_hmac(
            'sha256',
            "$headerB64.$payloadB64",
            $secret,
            true
        );

        $expectedSignatureB64 = rtrim(strtr(base64_encode($expectedSignature), '+/', '-_'), '=');


        if (!hash_equals($expectedSignatureB64, $signatureB64)) {
            return null;
        }


        $payload = json_decode(base64_decode(strtr($payloadB64, '-_', '+/')), true);

        if (!isset($payload['exp']) || time() > $payload['exp']) {
            return null;
        }

        return $payload;
    }
}

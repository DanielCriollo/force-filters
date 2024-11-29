<?php

namespace App\Handler;

use Illuminate\Http\Request;
use Spatie\WebhookClient\Exceptions\WebhookFailed;
use Spatie\WebhookClient\WebhookConfig;
use Spatie\WebhookClient\SignatureValidator\SignatureValidator;

class WppSignature implements SignatureValidator
{
    public function isValid(Request $request, WebhookConfig $config): bool
{
        // Obtén la firma del encabezado (ajusta el nombre según el servicio externo)
        $signature = $request->header('Signature');

        if (!$signature) {
            //throw new InvalidSignature("No se encontró la firma en el encabezado.");
        }

        // Obtén el cuerpo de la solicitud
        $payload = $request->getContent();

        // Obtén la clave secreta del webhook (desde la configuración o el archivo .env)
        $secret = $config->signingSecret;

        // Genera la firma esperada usando HMAC-SHA256 (o el método que necesites)
        $expectedSignature = hash_hmac('sha256', $payload, $secret);

        // Compara la firma recibida con la esperada
        if (!hash_equals($expectedSignature, $signature)) {
            //throw new InvalidSignature("La firma no coincide.");
        }

        return true; // Firma válida
    }//
}
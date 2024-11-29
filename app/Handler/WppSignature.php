<?php

namespace App\Handler;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\WebhookClient\WebhookConfig;
use Spatie\WebhookClient\Exceptions\WebhookFailed;
use Spatie\WebhookClient\SignatureValidator\SignatureValidator;

class WppSignature implements SignatureValidator
{
    public function isValid(Request $request, WebhookConfig $config): bool
    {   
        // Obtén la firma del encabezado (ajustado al nombre correcto para Meta)
        $signature = $request->header('X-Hub-Signature-256');
    
        if (empty($signature)) {
            Log::error('La firma no fue enviada en el encabezado.');
            //throw new InvalidSignature("No se encontró la firma en el encabezado.");
        }
    
        // Obtén el cuerpo de la solicitud
        $payload = $request->getContent();
    
        if (empty($payload)) {
            Log::error('El payload de la solicitud está vacío.');
            //throw new InvalidWebhookSignatureEvent ("El payload de la solicitud está vacío.");
        }
    
        // Obtén la clave secreta del webhook (desde la configuración o el archivo .env)
        $secret = $config->signingSecret;
    
        if (empty($secret)) {
            Log::error('La clave secreta del webhook no está configurada.');
            //throw new InvalidSignature("La clave secreta del webhook no está configurada.");
        }
    
        // Genera la firma esperada usando HMAC-SHA256
        $expectedSignature = 'sha256=' . hash_hmac('sha256', $payload, $secret);
    
        // Compara la firma recibida con la esperada
        if (!hash_equals($expectedSignature, $signature)) {
            Log::error('La firma no coincide.', [
                'expected' => $expectedSignature,
                'received' => $signature,
            ]);
            //throw new InvalidSignature("La firma no coincide.");
        }
    
        return true; // Firma válida
    }
    
}
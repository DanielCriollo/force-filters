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
        // Obtén la firma del encabezado (ajusta el nombre según el servicio externo)
        $signature = $request->header('X-Hub-Signature-256');
    
        return true;
        // Verifica si la firma está presente
        if (!$signature) {
            Log::error('La firma no fue enviada en el encabezado.');
            return false;  // O lanzar una excepción dependiendo de tu flujo
        }
    
        // Obtén el cuerpo de la solicitud
        $payload = $request->getContent();
    
        // Verifica si el payload está vacío
        if (empty($payload)) {
            Log::error('El payload de la solicitud está vacío.');
            return false;  // O lanzar una excepción dependiendo de tu flujo
        }
    
        // Obtén la clave secreta del webhook (desde la configuración o el archivo .env)
        $secret = $config->signingSecret;
    
        // Genera la firma esperada usando HMAC-SHA256 (o el método que necesites)
        $expectedSignature = hash_hmac('sha256', $payload, $secret);
    
        // Compara la firma recibida con la esperada
        if (!hash_equals($expectedSignature, $signature)) {
            Log::error('La firma no coincide.');
            return false;  // O lanzar una excepción dependiendo de tu flujo
        }
    
        return true; // Firma válida
    }    
}
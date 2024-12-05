<?php
namespace App\Handler;

use Illuminate\Http\Request;
use Spatie\WebhookClient\WebhookConfig;
use Spatie\WebhookClient\WebhookResponse\RespondsToWebhook;
use Illuminate\Http\Response;

class CustomWebhookResponse implements RespondsToWebhook
{
    /**
     * Responde a un webhook válido.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Spatie\WebhookClient\WebhookConfig $config
     * @return \Illuminate\Http\Response
     */
    public function respondToValidWebhook(Request $request, WebhookConfig $config): Response
    {
        // Puedes realizar una lógica adicional aquí si es necesario

        // Si todo está correcto, Meta (WhatsApp) requiere un código 200 con una respuesta vacía
        return response('', 200);
    }
}

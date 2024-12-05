<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class WebhookController extends Controller
{
    private $verifyToken = 'Ducker++2024';

    public function handleWebhook(Request $request)
    {
        if ($request->isMethod('get')) {
            return $this->validateWebhook($request);
        }

        if ($request->isMethod('post')) {
            return $this->processWebhook($request);
        }

        return response()->json(['success' => false, 'message' => 'Invalid request method'], 405);
    }

    private function validateWebhook(Request $request)
    {
        try {
            $mode = $request->query('hub_mode');
            $token = $request->query('hub_verify_token');
            $challenge = $request->query('hub_challenge');

            if ($mode && $token) {
                if ($mode === 'subscribe' && $token === $this->verifyToken) {
                    return response($challenge, 200)
                        ->header('Content-Type', 'text/plain');
                }
            }

            throw new \Exception('Invalid mode or token');
        } catch (\Throwable $th) {
            Log::error('Webhook validation failed: ', [
                'error' => $th->getMessage(),
                'query' => $request->query(),
            ]);

            return response()->json([
                'success' => false,
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    private function processWebhook(Request $request)
    {
        Log::info($request);
        try {
            $bodyContent = json_decode($request->getContent(), true);

            if (isset($bodyContent['entry'][0]['changes'][0]['value'])) {
                $value = $bodyContent['entry'][0]['changes'][0]['value'];

                if (!empty($value['messages']) && $value['messages'][0]['type'] === 'text') {
                    $body = $value['messages'][0]['text']['body'];
                    $from = $value['messages'][0]['from']; 
                    Log::info('Received message: ' . $body);

                $responseMessage = 'Gracias por tu mensaje: "' . $body . '".';
                $this->sendMessageToWhatsApp($from, $responseMessage);
                
                    return response()->json([
                        'success' => true,
                        'data' => $body,
                    ], 200);
                }
            }

            throw new \Exception('No valid message found in the request');
        } catch (\Throwable $th) {
            Log::error('Error processing webhook: ', [
                'error' => $th->getMessage(),
                'request' => $request->getContent(),
            ]);

            return response()->json([
                'success' => false,
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    private function sendMessageToWhatsApp(string $recipient, string $message)
    {
        $token = env('WHATSAPP_ACCESS_TOKEN'); // El token de acceso para la API de Meta
        $phoneNumberId = env('WHATSAPP_PHONE_NUMBER_ID'); // El ID del número de WhatsApp de tu cuenta

        $endpoint = "https://graph.facebook.com/v16.0/{$phoneNumberId}/messages";

        $response = Http::withToken($token)->post($endpoint, [
            'messaging_product' => 'whatsapp',
            'to' => $recipient,
            'type' => 'text',
            'text' => [
                'body' => $message,
            ],
        ]);

        if ($response->failed()) {
            Log::error('Failed to send WhatsApp message:', [
                'recipient' => $recipient,
                'message' => $message,
                'response' => $response->body(),
            ]);

            throw new \Exception('Failed to send WhatsApp message: ' . $response->body());
        }

        Log::info('Message sent successfully to ' . $recipient, [
            'message' => $message,
            'response' => $response->body(),
        ]);
    }
}
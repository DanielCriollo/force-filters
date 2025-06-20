<?php

namespace App\Http\Controllers;

use el;
use App\Customer;
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

                    // Respuestas automáticas basadas en palabras clave
                    $responseMessage = $this->generateBotResponse($body);

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

    private function generateBotResponse(string $message): string
    {
        // Normalizamos la entrada para ignorar mayúsculas y minúsculas
        $message = strtolower($message);
    
        // Verificar si el mensaje contiene "consulta"
        if (strpos($message, 'consulta') !== false) {
            // Solicitar la identificación en el formato id:numerodeidentificacion
            return "Por favor, envía la identificación en el formato 'id:numerodeidentificacion'. Ejemplo: id:12345";
        }
    
        // Verificar si el mensaje comienza con "id:" para obtener la identificación
        if (strpos($message, 'id:') === 0) {
            // Recortar la identificación después de "id:"
            $identification = substr($message, 3);  // Elimina el "id:" y toma lo que sigue
        
            // Validar que la identificación no esté vacía y sea numérica
            if (empty($identification) || !is_numeric($identification)) {
                return "Por favor, proporciona un número de identificación válido después de 'id:'. Ejemplo: id:12345";
            }
        
            // Buscar el cliente en la base de datos
            $customer = Customer::where('identification', $identification)->first();
        
            // Si el cliente existe
            if ($customer) {
                // Almacenar la identificación en la sesión
                session(['customer_identification' => $identification]);
        
                return "¡Hola {$customer->name}! Selecciona una de las opciones:\n" .
                    "1. Consultar nombre\n" .
                    "2. Fecha de creación";
            } else {
                // Si el cliente no se encuentra
                return "Lo siento, no encontramos un cliente con esa identificación. Por favor, intenta nuevamente con un número válido.";
            }
        }
    
        // Verificar si hay una identificación en la sesión
        $identification = session('customer_identification');
        
        if ($identification) {
            // Buscar el cliente en la base de datos usando la identificación de la sesión
            $customer = Customer::where('identification', $identification)->first();
        
            // Si el cliente no existe en la base de datos
            if (!$customer) {
                return 'No encontramos un cliente con esa identificación. Por favor, envía una identificación válida.';
            }
        
            // Verificar la opción seleccionada (1 o 2)
            if (strpos($message, '1') !== false) {
                return "El nombre del cliente es: {$customer->name}";
            }
        
            if (strpos($message, '2') !== false) {
                return "La fecha de creación del cliente es: {$customer->created_at}";
            }
        }
    
        // Si no se reconoce la opción
        return 'No reconozco la opción. Vuelve a escribir "consulta" para ver las opciones.';
    }
    
}


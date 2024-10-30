<?php 
namespace App\Services;

use GuzzleHttp\Client;

class CaptchaResolverService
{
    private $apiKey;

    public function __construct()
    {
        $this->apiKey = env('CAPTCHA_API_KEY');  // API key del servicio de resolución de CAPTCHA
    }

    public function resolveCaptcha($captchaImageUrl)
    {
        $client = new Client();

        // Envía la imagen del CAPTCHA al servicio de 2Captcha para resolverla
        $response = $client->post('http://2captcha.com/in.php', [
            'form_params' => [
                'key' => $this->apiKey,
                'method' => 'base64',
                'body' => base64_encode(file_get_contents($captchaImageUrl)),
                'json' => 1
            ]
        ]);

        $captchaId = json_decode($response->getBody(), true)['request'];

        // Espera un momento hasta que el CAPTCHA sea resuelto
        sleep(10);

        // Obtén la respuesta del CAPTCHA resuelto
        $response = $client->get('http://2captcha.com/res.php', [
            'query' => [
                'key' => $this->apiKey,
                'action' => 'get',
                'id' => $captchaId,
                'json' => 1
            ]
        ]);

        return json_decode($response->getBody(), true)['request'];
    }
}

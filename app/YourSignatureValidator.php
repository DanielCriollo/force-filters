<?php

namespace App;

use Illuminate\Http\Request;
use Spatie\WebhookClient\WebhookConfig;
use Spatie\WebhookClient\SignatureValidator\SignatureValidator;
use Illuminate\Support\Facades\Log;

class YourSignatureValidator implements SignatureValidator
{
    public function isValid(Request $request, WebhookConfig $config)/* : bool */
    {
        Log::info('Here signature');
        /* return true; */
            //TOQUEN QUE QUERRAMOS PONER
        $token = 'Ducker++2024';
        //RETO QUE RECIBIREMOS DE FACEBOOK
        //$hub_challenge = isset($_GET['hub_challenge']) ? $_GET['hub_challenge'] : '';
        $hub_challenge = isset($request->hub_challenge) ? $request->hub_challenge: '';

        //TOQUEN DE VERIFICACION QUE RECIBIREMOS DE FACEBOOK
        $hub_verify_token = isset($_GET['hub_verify_token']) ? $_GET['hub_verify_token'] : '';
        //SI EL TOKEN QUE GENERAMOS ES EL MISMO QUE NOS ENVIA FACEBOOK RETORNAMOS EL RETO PARA VALIDAR QUE SOMOS NOSOTROS
        if ($token === $hub_verify_token) {
            echo $hub_challenge;
            exit;
            Log::info('Verify');
        }
    }
}
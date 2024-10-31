<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\VehicleCaptureCheckService;

class TestController extends Controller
{
    protected $vehicleCaptureCheckService;

    // Inyectar el servicio en el constructor
    public function __construct(VehicleCaptureCheckService $vehicleCaptureCheckService)
    {
        $this->vehicleCaptureCheckService = $vehicleCaptureCheckService;
    }

    // Método que recibe el número del vehículo y la URL de la imagen CAPTCHA
    public function checkVehicleCapture(Request $request)
    {
        $result = $this->vehicleCaptureCheckService->checkVehicle('UUU','https://www.sat.gob.pe/VirtualSAT/controles/JpegImage_VB.aspx?r=ed6f2d9ac5c945359e0cba6bb65d62fd');
        return $result;
        // Validar los datos entrantes
        $request->validate([
            'vehicle_number' => 'required|string',
            'captcha_image_url' => 'required|url',
        ]);

        // Obtener los datos del request
        $vehicleNumber = $request->input('vehicle_number');
        $captchaImageUrl = $request->input('captcha_image_url');

        // Llamar al servicio para hacer la consulta
        $result = $this->vehicleCaptureCheckService->checkVehicle('UUU','https://www.sat.gob.pe/VirtualSAT/controles/JpegImage_VB.aspx?r=ed6f2d9ac5c945359e0cba6bb65d62fd');

        // Devolver el resultado en formato JSON
        return response()->json(['result' => $result]);
    }
}
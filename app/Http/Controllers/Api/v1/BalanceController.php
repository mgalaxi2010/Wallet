<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class BalanceController extends Controller
{
    public function __invoke(): \Illuminate\Http\JsonResponse
    {
        $balance = 0;
        $errors = "";
        $message = "total of ";
        $success = false;
        $urls = [
            "mock_a" => ['url' => 'https://vandar.ir/mock/a',
                'bank' => false],
            "mock_b" => ['url' => 'https://vandar.ir/mock/b',
                'bank' => true]
        ];
        foreach ($urls as $key => $url) {
            try {
                $response = json_decode(file_get_contents($url['url']), true);
                if ($response['status']['code'] == Response::HTTP_OK) {
                    if($url['bank']){
                        $balance += intval($response['data']['bank']['balance']);
                    }else{
                        $balance += intval($response['data']['balance']);
                    }
                    $message .= $key." ";
                    $success = true;
                } else {
                    $errors .= $response['error'];
                }
            }catch (\Exception $e){
                $errors .=  $e->getMessage();
            }
        }
        $message = $success?$message:$errors;
        return generalResponse($success, ['balance'=>$balance], $message, Response::HTTP_OK);
    }
}

<?php

namespace App\Helper;

use Illuminate\Support\Str;

class ApiResponse
{
    /**
     * @param $data
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public $paginate = false;
    public $class;
    public array $meta = [];

    public function paginate($class)
    {
        $this->paginate = true;
        $this->class = $class;
        return $this;
    }

    public function meta(array $array)
    {
        $this->meta = $array;
        return $this;
    }

    public function generalResponse($success, $data, $message, int $statusCode = 200)
    {
        $error = null;
        if (!$success) {
            $error = [
                'errorCode' => 0,
                'message' => $message,
            ];

        }

        $dataArray = [
            'apiVersion' => '1.0',
            "success" => $success,
            "result" => $success ? $data : null,
            "error" => $error,
            "paginate" => $this->paginate,
            "message" => $message,
        ];

        if ($this->paginate) {

            $meta = [
                'paginateHelper' => [
                    'currentPage' => $data->currentPage(),
                    'currentCount' => $data->count(),
                    'requestId' => Str::random( 5),
                    'total' => $data->total(),
                    'pageSize' => (int)$data->perPage(),
                    'lastPage' => $data->lastPage(),
                    'getOptions' => $data->links(),
                ]
            ];
            $dataArray['result'] = ['items' => new $this->class($data->items()),
                'meta' => array_merge($meta, $this->meta)
            ];
        }


        return response()->json($dataArray, $statusCode);
    }


}

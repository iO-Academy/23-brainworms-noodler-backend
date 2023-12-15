<?php

namespace App\Controllers;

use App\Abstracts\Controller;
use App\Models\NoodleModel;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class AddNoodleController extends Controller
{
    private NoodleModel $noodleModel;

    public function __construct(NoodleModel $noodleModel)
    {
        $this->noodleModel = $noodleModel;
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        $parsedBody = $request->getParsedBody();
        $id = $parsedBody['id'];
        $time = date("Y-m-d H:i:s", time());
        $noodle = $parsedBody['noodle'];
        $statusCode = 401;

        $data = ['success' => false, 'msg' => 'Unknown error'];
        echo !$noodle;

        if ($id || $noodle) {
            $newNoodleId = $this->noodleModel->addNoodle($id, $time, $noodle);
            $data = ['success' => true, 'msg' => 'Added noodle successfully', 'noodleId' => $newNoodleId];
            $statusCode = 200;
        }
        return $this->respondWithJson($response, $data, $statusCode);
    }
}

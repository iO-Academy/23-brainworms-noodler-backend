<?php

namespace App\Controllers;

use App\Abstracts\Controller;
use App\Models\NoodleModel;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class NoodleController extends Controller
{
    private NoodleModel $noodleModel;

    public function __construct(NoodleModel $noodleModel)
    {
        $this->noodleModel = $noodleModel;
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        $id = $args['id'];
        $noodles = $this->noodleModel->getNoodlesByUserId($id);
        return $this->respondWithJson($response, $noodles);
    }
}

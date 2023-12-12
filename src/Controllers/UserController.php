<?php

namespace App\Controllers;

use App\Abstracts\Controller;
use App\Models\UserModel;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class UserController extends Controller
{
    private UserModel $userModel;

    public function __construct(UserModel $userModel)
    {
        $this->userModel = $userModel;
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];
        $userData = $this->userModel->getUserDataById($id);

        $data = ['success' => true, 'msg' => 'Retrieved user data.', 'data' => $userData];

        return $this->respondWithJson($response, $data);
    }
}

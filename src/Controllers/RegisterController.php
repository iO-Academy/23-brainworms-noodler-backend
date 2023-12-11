<?php


namespace App\Controllers;

use App\Abstracts\Controller;
use App\Models\UserModel;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use function DI\string;

class RegisterController extends Controller
{
    private UserModel $userModel;

    public function __construct(UserModel $userModel)
    {
        $this->userModel = $userModel;
    }

    /**
     * Verifies user credentials then returns message and status code with login success status and attached message.
     */
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $parsedBody = $request->getParsedBody();
        $result = $this->userModel->insertNewUserToDb($parsedBody['username'], $parsedBody['description'], $parsedBody['email'], $parsedBody['password']);
        return $this->respondWithJson($response, 'withtest');
    }
}

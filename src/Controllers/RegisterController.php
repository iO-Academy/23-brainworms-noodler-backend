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

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $parsedBody = $request->getParsedBody();
        $email = $parsedBody['email'];
        $username = $parsedBody['username'];
        $password = $parsedBody['password'];
        $validEmail = $this->userModel->validateEmail($email);
        $checkEmailOrUsernameExist = $this->userModel->getUserByEmailOrUsername($email, $username);
        $data = ['success' => false, 'msg' => 'Unknown error'];
        $statusCode = 401;

        if (!$validEmail) {
            $data['msg'] = 'Invalid email address';
        } elseif (!$checkEmailOrUsernameExist) {
            $uppercase = preg_match('@[A-Z]@', $password);
            $lowercase = preg_match('@[a-z]@', $password);
            $number    = preg_match('@[0-9]@', $password);
            $specialChars = preg_match('@[^\w]@', $password);

            if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
                $data['msg'] = 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $newUserId = $this->userModel->insertNewUserToDb($username, $parsedBody['description'], $email, $hashedPassword);
                $data = ['success' => true, 'msg' => 'Added new user to database', 'userId' => $newUserId];
                $statusCode = 200;
            }

        } elseif ($checkEmailOrUsernameExist['email'] === $email) {
            $data['msg'] = 'Email already used';
        } elseif ($checkEmailOrUsernameExist['username'] === $username) {
            $data['msg'] = 'Username already used';
        }
        return $this->respondWithJson($response, $data, $statusCode);
    }
}

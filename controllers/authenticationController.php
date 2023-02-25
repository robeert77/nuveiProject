<?php
namespace controllers;

use \includes\View;
use \includes\Controller;
use \includes\Validator;
use \models\UserModel;
use \models\HobbyModel;
use \models\CategoryModel;
use \models\DepartmentModel;

class AuthenticationController extends Controller {
    public function index() {
        $viewData = array('registerURL' => CORE_URI . '/authentication/register/',
                    'login' => CORE_URI . '/authentication/login');

        $view = new View($viewData);
        $view->renderView('mainAuthentication');
    }

    public function register($args = array()) {
        $viewData = array();

        $hobbyModel = new HobbyModel();
        $categoryModel = new CategoryModel();
        $departmentModel = new DepartmentModel();
        $viewData['hobbies'] = $hobbyModel->getArray();
        $viewData['categories'] = $categoryModel->getArray();
        $viewData['departments'] = array(0 => 'Alege') + $departmentModel->getArray();

        $viewData['formAction'] = CORE_URI . '/authentication/saveUser/';
        $viewData['isInvalid'] = false;

        $view = new View($viewData);
        $view->renderView('register');
    }

    public function saveUser($args = array()) {
        $data = array(
            'username' => isset($_POST['username']) ? $_POST['username'] : '',
            'password' => isset($_POST['password']) ? $_POST['password'] : '',
            'confirmPassword' => isset($_POST['confirmPassword']) ? $_POST['confirmPassword'] : '',
            'email' => isset($_POST['email']) ? $_POST['email'] : '',
            'id_department' => isset($_POST['id_department']) ? $_POST['id_department'] : '0',
            'id_category' => isset($_POST['id_category']) ? $_POST['id_category'] : array(),
            'id_hobby' => isset($_POST['id_hobby']) ? $_POST['id_hobby'] : '0',
            'termsConditions' => isset($_POST['termsConditions']) ? $_POST['termsConditions'] : '',
        );

        $rules = array(
            'username' => 'required|min_chars:6|max_chars:50|unique:user',
            'password' => 'required|min_chars:8|password:' . $data['confirmPassword'],
            'confirmPassword' => 'required',
            'email' => 'required|email|unique:user',
            'termsConditions' => 'required',
        );

        $viewData = array();
        $validator = new Validator($data, $rules);
        if ($validator->validate()) {
            $row = $data;
            unset($row['confirmPassword'], $row['termsConditions']);

            $userModel = new UserModel();
            $idUser = $userModel->save($row);

            $viewData['registerURL'] =  CORE_URI . '/authentication/register/';
            $viewData['loginURL'] =  CORE_URI . '/authentication/login/';
            $_SESSION['success_registration'] = "New user registrer succesfully!";

            $view = new View($viewData);
            $view->renderView('mainAuthentication');
            return;
        }

        $hobbyModel = new HobbyModel();
        $categoryModel = new CategoryModel();
        $departmentModel = new DepartmentModel();
        $viewData['hobbies'] = $hobbyModel->getArray();
        $viewData['categories'] = $categoryModel->getArray();
        $viewData['departments'] = array(0 => 'Alege') + $departmentModel->getArray();

        $viewData['oldValues'] = $data;
        $viewData['formAction'] = CORE_URI . '/authentication/saveUser/';
        $viewData['isInvalid'] = true;
        $viewData['errors'] = $validator->getErrors();

        $view = new View($viewData);
        $view->renderView('register');
    }
}

<?php
namespace includes;

use \models\UserModel;

class Validator {
    private $data;
    private $rules;
    private $errors;

    public function __construct($data, $rules) {
        $this->data = $data;
        $this->rules = $rules;
    }

    public function validate() {
        foreach ($this->rules as $field => $fieldRules) {
            $currentRules = explode('|', $fieldRules);

            foreach ($currentRules as $rule) {
                $parameters = array();

                if (strpos($rule, ':') !== false) {
                    list($rule, $parameters) = explode(':', $rule);
                    $parameters = explode(',', $parameters);
                }

                $value = isset($this->data[$field]) ? $this->data[$field] : '';
                $errorMessage = $this->$rule($value, $field, $parameters);
                if ($errorMessage) {
                    $this->addErrors($field, $errorMessage);
                }
            }
        }

        return empty($this->errors);
    }

    public function getErrors() {
        return $this->errors;
    }

    private function addErrors($field, $message) {
        if (is_array($message)) {
            $this->errors[$field] = array_merge(
                isset($this->errors[$field]) ? $this->errors[$field] : array(),
                $message
            );
        }
        else {
            $this->errors[$field][] = $message;
        }
    }

    private function required($value, $field) {
        if (empty($value)) {
            return 'The ' . $field . ' field is required.';
        }
        return '';
    }

    private function min_chars($value, $field, $parameters) {
        if (strlen($value) < $parameters[0]) {
            return 'The ' . $field . ' field must be at least ' . $parameters[0] . ' chars long.';
        }
        return '';
    }

    private function max_chars($value, $field, $parameters) {
        if (strlen($value) > $parameters[0]) {
            return 'The ' . $field . ' field must be no more than ' . $parameters[0] . ' chars long.';
        }
        return '';
    }

    private function email($value, $field) {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return 'The ' . $field . ' field must be an valid email address.';
        }
        return '';
    }

    // expect: 'password' => 'password:' . $confirmPassword . '|min_chars:8'
    private function password($value, $field, $parameters) {
        $errorMessage = array();
        // Check if password is identical with confirmPassword
        if ($value !== $parameters[0]) {
            $errorMessage[] = 'The ' . $field . ' field must be identical with confirm ' . $field . ' field.';
        }

        // Check if password contains at least one upper letter
        if (!preg_match('/[A-Z]/', $value)) {
            $errorMessage[] = 'The ' . $field . ' field must contain at least on upper letter.';
        }

        // Check if password contains at least one lowercase letter
        if (!preg_match('/[a-z]/', $value)) {
            $errorMessage[] = 'The ' . $field . ' field must contain at least on lower letter.';
        }

        // Check if password contains at least one special character
        if (!preg_match('/[!@#\$%\^&\*\(\)\-=]/', $value)) {
            $errorMessage[] = 'The ' . $field . ' field must contain at least one special char: "!@#$%^&*()-=" .';
        }

        return $errorMessage;
    }

    private function unique($value, $field, $parameters) {
        $className = '\\models\\' . $parameters[0] . 'Model';
        $fieldModel = new $className();
        $doesExist = $fieldModel->getOne(array($field => $value));

        if ($doesExist) {
            return 'This ' . $field . ' is already taken and have to be unique.';
        }
        return '';
    }
}

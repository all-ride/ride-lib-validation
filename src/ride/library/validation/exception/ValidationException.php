<?php

namespace ride\library\validation\exception;

use ride\library\validation\ValidationError;

use \Exception;
use \InvalidArgumentException;

/**
 * ValidationException containing the ValidationErrors
 */
class ValidationException extends Exception {

    /**
     * Array with the errors per field
     * @var array
     */
    private $errors;

    /**
     * Constructs a new validation exception
     * @param string $message
     * @param integer $code
     * @param Exception $previous
     * @return null
     */
    public function __construct($message = 'Validation errors occured', $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);

        $this->errors = array();
    }

    /**
     * Adds a error for a field
     * @param string $name Name of the field
     * @param ride\library\validation\ValidationError $error Validation error
     * @return null
     */
    public function addError($name, ValidationError $error) {
        if (!isset($this->errors[$name])) {
            $this->errors[$name] = array();
        }

        $this->errors[$name][] = $error;
    }

    /**
     * Add errors for a field
     * @param string $name Name of the field
     * @param array $errors Array containing ValidationError instances
     * @return null
     * @throws InvalidArgumentException when a value of the errors array is not
     * a ValidationError instance
     */
    public function addErrors($name, array $errors) {
        if (!$errors) {
            return;
        }

        if (!isset($this->errors[$name])) {
            $this->errors[$name] = array();
        }

        foreach ($errors as $error) {
            if (!($error instanceof ValidationError)) {
                throw new InvalidArgumentException('Could not add error: provided error is not a ValidationError');
            }

            $this->errors[$name][] = $error;
        }
    }

    /**
     * Check whether this exception contains errors
     * @param string $name To check whether there are errors for a certain
     * field, provide the field name. To check for any errors, provide null.
     * @return boolean True if there are errors, false otherwise
     */
    public function hasErrors($name = null) {
        if ($name == null) {
            return !empty($this->errors);
        }

        return isset($this->errors[$name]);
    }

    /**
     * Get the errors for a field
     * @param string $name name of the field
     * @return array Array with ValidationError instances
     */
    public function getErrors($name) {
        if (!$this->hasErrors($name)) {
            return array();
        }

        return $this->errors[$name];
    }

    /**
     * Get all the error of this exception
     * @return array Array with the field name as key and an array with ValidationError instances as value
     */
    public function getAllErrors() {
        return $this->errors;
    }

    /**
     * Get all the errors as a html string
     * @return string html representation of the errors in this exception
     */
    public function getErrorsAsString() {
        if (!$this->hasErrors()) {
            return;
        }

        $string = '<ul>';
        foreach ($this->errors as $name => $errors) {
            $string .= '<li>' . $this->getFieldErrorsAsString($name, $errors) . '</li>';
        }
        $string .= '</ul>';

        return $string;
    }

    /**
     * Get the errors for a field as a string
     * @param string $name name of the field
     * @param array $errors Array containing ValidationError objects
     * @return string html representation of the provided errors
     */
    private function getFieldErrorsAsString($name, $errors) {
        $string = ucfirst($name) . ': ';

        if (count($errors) == 1) {
            $error = array_pop($errors);
            $string .= $error;
        } else {
            $string .= '<ul>';
            foreach ($errors as $error) {
                $string .= '<li>' . $error . '</li>';
            }
            $string .= '</ul>';
        }

        return $string;
    }

}
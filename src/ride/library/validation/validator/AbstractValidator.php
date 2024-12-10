<?php

namespace ride\library\validation\validator;

use ride\library\validation\ValidationError;

/**
 * Abstract Validator implementation with basic error handling functions
 */
abstract class AbstractValidator implements Validator {

    /**
     * Options for the validator
     * @var array
     */
    protected $options;

    /**
     * Array with the ValidationError objects
     * @var array
     */
    protected $errors;

    /**
     * Constructs a new validator instance
     * @param array $options options for the validator
     * @return null
     */
    public function __construct(array $options = null) {
        $this->options = $options;
        $this->errors = array();
    }

    /**
     * Gets the machine name of this validator
     * @return string
     */
    public function getName() {
        return static::NAME;
    }

    /**
     * Gets the options of this validator
     * @return array Array with the options
     */
    public function getOptions() {
        return $this->options ? $this->options : array();
    }

    /**
     * Get an option of this validator
     * @param string $name Name of the option
     * @param mixed $default Default value to return when the option is not set
     * @return mixed
     */
    public function getOption($name, $default = null) {
        if (!isset($this->options[$name])) {
            return $default;
        }

        return $this->options[$name];
    }

    /**
     * Adds an error to this validator
     * @param string $code Code or translation key for the error
     * @param string $message Message of the error
     * @param array $parameters Parameters for variables in the message
     * @return null
     */
    protected function addValidationError($code, $message, $parameters) {
        $this->errors[] = new ValidationError($code, $message, $parameters);
    }

    /**
     * Adds an error to this validator
     * @param \ride\library\validation\ValidationError $error
     * @return null
     */
    protected function addError(ValidationError $error) {
        $this->errors[] = $error;
    }

    /**
     * Gets the errors of the last isValid call
     * @return array Array with ride\library\validation\ValidationError objects
     */
    public function getErrors() {
        return $this->errors;
    }

    /**
     * Clears the errors
     * @return null
     */
    protected function resetErrors() {
        $this->errors = array();
    }

}

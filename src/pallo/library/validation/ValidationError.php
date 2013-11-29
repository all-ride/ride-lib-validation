<?php

namespace pallo\library\validation;

use \InvalidArgumentException;

/**
 * Data container of a validation error
 */
class ValidationError {

    /**
     * Code of the error
     * @var string
     */
    private $code;

    /**
     * Message of the error
     * @var string
     */
    private $message;

    /**
     * Parameters for the error message
     * @var array
     */
    private $parameters;

    /**
     * Constructs a new validation error
     * @param string $code Code or translation key of the error
     * @param string $message Message of the error
     * @param array $parameters Parameters for the message of the error
     * @return null
     * @throws Exception when the provided code or message is empty or invalid
     */
    public function __construct($code, $message, array $parameters = array()) {
        $this->setCode($code);
        $this->setMessage($message);
        $this->parameters = $parameters;
    }

    /**
     * Gets the message of this error as a string with the parameters parsed
     * into
     * @return string
     */
    public function __toString() {
        if (!$this->parameters) {
            return $this->message;
        }

        $string = $this->message;

        foreach ($this->parameters as $key => $value) {
            if (!is_scalar($value)) {
                if (is_object($value)) {
                    $value = gettype($value);
                } else {
                    $value = 'Array';
                }
            }

            $string = str_replace('%' . $key . '%', $value, $string);
        }

        return $string;
    }

    /**
     * Sets the code of this error
     * @param string $code
     * @return null
     * @throws Exception when the code is empty or invalid
     */
    private function setCode($code) {
        if (!is_string($code) || $code === '') {
            throw new InvalidArgumentException('Provided code is empty or invalid');
        }

        $this->code = $code;
    }

    /**
     * Gets the code of this error
     * @return string
     */
    public function getCode() {
        return $this->code;
    }

    /**
     * Sets the message of this error
     * @param string $message
     * @return null
     * @throws Exception when the message is empty or invalid
     */
    private function setMessage($message) {
        if (!is_string($message) || $message === '') {
            throw new InvalidArgumentException('Provided message is empty');
        }

        $this->message = $message;
    }

    /**
     * Gets the message of this error
     * @return string
     */
    public function getMessage() {
        return $this->message;
    }

    /**
     * Gets the parameters for the message of this error
     * @return array
     */
    public function getParameters() {
        return $this->parameters;
    }

}
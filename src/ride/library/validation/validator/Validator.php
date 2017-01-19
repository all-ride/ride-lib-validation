<?php

namespace ride\library\validation\validator;

/**
 * Interface for a validator
 */
interface Validator {

    /**
     * Constructs a new validator instance
     * @param array $options Options for this validator
     * @return null
     */
    public function __construct(array $options = null);

    /**
     * Gets the machine name of this validator
     * @return string
     */
    public function getName();

    /**
     * Gets the options of this validator
     * @return array Array with the options
     */
    public function getOptions();

    /**
     * Checks if the provided value is valid
     * @param mixed $value Value to check
     * @return boolean True when the value is valid, false otherwise
     */
    public function isValid($value);

    /**
     * Get the errors of the last isValid call
     * @return array Array with \ride\library\validation\ValidationError objects
     */
    public function getErrors();

}

<?php

namespace pallo\library\validation\validator;

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
     * Checks if the provided value is valid
     * @param mixed $value Value to check
     * @return boolean True when the value is valid, false otherwise
     */
    public function isValid($value);

    /**
     * Get the errors of the last isValid call
     * @return array Array with pallo\library\validation\ValidationError objects
     */
    public function getErrors();

}
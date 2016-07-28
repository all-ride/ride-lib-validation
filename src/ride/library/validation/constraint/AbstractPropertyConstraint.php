<?php

namespace ride\library\validation\constraint;

use ride\library\reflection\ReflectionHelper;
use ride\library\validation\exception\ValidationException;
use ride\library\validation\validator\RequiredValidator;
use ride\library\validation\ValidationError;

/**
 * Constraint to ensure one of the provided properties is set
 */
abstract class AbstractPropertyConstraint implements Constraint {

    /**
     * Instance of the reflection helper
     * @var \ride\library\reflection\ReflectionHelper
     */
    protected $reflectionHelper;

    /**
     * Property names
     * @var array
     */
    protected $properties;

    /**
     * Custom error code
     * @var string
     */
    protected $error;

    /**
     * Constructs a new constraint
     * @return null
     */
    public function __construct(ReflectionHelper $reflectionHelper = null) {
        if ($reflectionHelper) {
            $this->reflectionHelper = $reflectionHelper;
        } else {
            $this->reflectionHelper = new ReflectionHelper();
        }

        $this->properties = array();
        $this->error = static::ERROR;
    }

    /**
     * Sets the error code for the validation error
     * @param string $error
     * @return null
     */
    public function setError($error) {
        $this->error = $error;
    }

    /**
     * Adds a property
     * @param string $property Name of the property
     * @return null
     */
    public function addProperty($property) {
        $this->properties[$property] = true;
    }

}

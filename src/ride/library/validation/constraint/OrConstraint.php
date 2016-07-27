<?php

namespace ride\library\validation\constraint;

use ride\library\reflection\ReflectionHelper;
use ride\library\validation\exception\ValidationException;
use ride\library\validation\validator\RequiredValidator;
use ride\library\validation\ValidationError;

/**
 * Constraint to ensure one of the provided properties is set
 */
class OrConstraint implements Constraint {

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
        $this->error = 'error.validation.required.or';
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

    /**
     * Constrains the provided instance
     * @param array|object $isntance Instance to be validated
     * @param \ride\library\validation\exception\ValidationException $exception
     * @return array|object Filtered and validated instance
     * @throws \ride\library\validation\exception\ValidationException when the
     * instance could not be validated and no exception is provided
     */
    public function constrain($instance, ValidationException $exception = null) {
        if (!$this->properties) {
            return;
        }

        if ($exception) {
            $throwException = false;
        } else {
            $throwException = true;

            $exception = new ValidationException();
        }

        $validator = new RequiredValidator();
        $isValid = false;

        $requiredException = new ValidationException();
        foreach ($this->properties as $property => $null) {
            $value = $this->reflectionHelper->getProperty($instance, $property);

            if ($validator->isValid($value, $requiredException)) {
                $isValid = true;

                break;
            }
        }

        if (!$isValid) {
            $error = new ValidationError($this->error, 'You might want to fill in this field');

            foreach ($this->properties as $property => $null) {
                $exception->addError($property, $error);
            }
        }

        if ($throwException && $exception->hasErrors()) {
            throw $exception;
        }

        return $instance;
    }

}

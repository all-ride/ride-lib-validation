<?php

namespace ride\library\validation\constraint;

use ride\library\reflection\ReflectionHelper;
use ride\library\validation\exception\ValidationException;
use ride\library\validation\ValidationError;

/**
 * Constraint to ensure the same value in different properties
 */
class EqualsConstraint implements Constraint {

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
     * Constructs a new generic constraint
     * @return null
     */
    public function __construct(ReflectionHelper $reflectionHelper = null) {
        if ($reflectionHelper) {
            $this->reflectionHelper = $reflectionHelper;
        } else {
            $this->reflectionHelper = new ReflectionHelper();
        }

        $this->properties = array();
    }

    /**
     * Adds a property which should have the same value as other assigned
     * properties
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

        $equalsValue = null;
        $firstField = null;

        foreach ($this->properties as $property => $null) {
            $value = $this->reflectionHelper->getProperty($instance, $property);

            if ($firstField === null) {
                $equalsValue = $value;

                $firstField = $property;
            } elseif ($equalsValue !== $value) {
                $exception->addError($property, new ValidationError('error.validation.equals', 'Value should be the same as the ' . $firstField . ' field'));
            }
        }

        if ($throwException && $exception->hasErrors()) {
            throw $exception;
        }

        return $instance;
    }

}

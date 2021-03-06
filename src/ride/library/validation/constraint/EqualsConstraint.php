<?php

namespace ride\library\validation\constraint;

use ride\library\reflection\ReflectionHelper;
use ride\library\validation\exception\ValidationException;
use ride\library\validation\ValidationError;

/**
 * Constraint to ensure the same value in different properties
 */
class EqualsConstraint extends AbstractPropertyConstraint {

    /**
     * Default error of this constraint
     * @var string
     */
    const ERROR = 'error.validation.equals';

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
                $exception->addError($property, new ValidationError($this->error, 'Value should be the same as the ' . $firstField . ' field'));
            }
        }

        if ($throwException && $exception->hasErrors()) {
            throw $exception;
        }

        return $instance;
    }

}

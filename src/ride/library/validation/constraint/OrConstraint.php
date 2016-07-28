<?php

namespace ride\library\validation\constraint;

use ride\library\reflection\ReflectionHelper;
use ride\library\validation\exception\ValidationException;
use ride\library\validation\validator\RequiredValidator;
use ride\library\validation\ValidationError;

/**
 * Constraint to ensure one of the provided properties is set
 */
class OrConstraint extends AbstractPropertyConstraint {

    /**
     * Default error of this constraint
     * @var string
     */
    const ERROR = 'error.validation.required.or';

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

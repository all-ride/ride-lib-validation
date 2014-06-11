<?php

namespace ride\library\validation\constraint;

use ride\library\reflection\ReflectionHelper;
use ride\library\validation\exception\ValidationException;
use ride\library\validation\filter\Filter;
use ride\library\validation\validator\Validator;

/**
 * Constraint to validate a data container
 */
class GenericConstraint implements Constraint {

    /**
     * Instance of the reflection helper
     * @var \ride\library\reflection\ReflectionHelper
     */
    protected $reflectionHelper;

    /**
     * Filter per property
     * @var array
     */
    protected $filters;

    /**
     * Validators per property
     * @var array
     */
    protected $validators;

    /**
     * Nested constraints
     * @var array
     */
    protected $constraints;

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

        $this->filters = array();
        $this->validators = array();
        $this->constraints = array();
    }

    /**
     * Adds a filter for the provided property
     * @param \ride\library\validation\filter\Filter $filter Filter for the
     * @param string $property Name of the property
     * property
     * @return null
     */
    public function addFilter(Filter $filter, $property) {
        if (!isset($this->filters[$property])) {
            $this->filters[$property] = array();
        }

        $this->filters[$property][] = $filter;
    }

    /**
     * Gets the filters of this constraint
     * @param string $property Provide a property name to get filters of this
     * property
     * @return array Array with filters when a property has been provided, an
     * array with the name of the property as key and an array of filters when
     * no property has been provided
     */
    public function getFilters($property = null) {
        if (!$property) {
            return $this->filters;
        }

        if (!isset($this->filters[$property])) {
            return array();
        }

        return $this->filters[$property];
    }

    /**
     * Adds a validator for the provided property
     * @param \ride\library\validation\validator\Validator $validator Validator
     * @param string $property Name of the property
     * for the property
     * @return null
     */
    public function addValidator(Validator $validator, $property) {
        if (!isset($this->validators[$property])) {
            $this->validators[$property] = array();
        }

        $this->validators[$property][] = $validator;
    }


    /**
     * Gets the validators of this constraint
     * @param string $property Provide a property name to get validators of this
     * property
     * @return array Array with validators when a property has been provided, an
     * array with the name of the property as key and an array of validators when
     * no property has been provided
     */
    public function getValidators($property = null) {
        if (!$property) {
            return $this->validators;
        }

        if (!isset($this->validators[$property])) {
            return array();
        }

        return $this->validators[$property];
    }

    /**
     * Adds a nested constraint
     * @param Constraint $constraint Constraint
     * @return null
     */
    public function addConstraint(Constraint $constraint) {
        $this->constraints[] = $constraint;
    }

    /**
     * Validates the provided entry
     * @param array|object $entry Entry to be validated
     * @param \ride\library\validation\exception\ValidationException $exception
     * @return array|object Filtered and validated entry
     * @throws \ride\library\validation\exception\ValidationException when the
     * entry could not be validated and no exception is provided
     */
    public function validateEntry($entry, ValidationException $exception = null) {
        foreach ($this->filters as $property => $filters) {
            $value = $this->reflectionHelper->getProperty($entry, $property);
            if ($value === null) {
                continue;
            }

            foreach ($filters as $filter) {
                $value = $filter->filter($value);
            }

            $this->reflectionHelper->setProperty($entry, $property, $value);
        }

        if ($exception) {
            $throwException = false;
        } else {
            $throwException = true;

            $exception = new ValidationException();
        }

        foreach ($this->validators as $property => $validators) {
            $value = $this->reflectionHelper->getProperty($entry, $property);

            foreach ($validators as $validator) {
                if ($validator->isValid($value)) {
                    continue;
                }

                $exception->addErrors($property, $validator->getErrors());
            }
        }

        foreach ($this->constraints as $constraint) {
            $entry = $constraint->validateEntry($entry, $exception);
        }

        if ($throwException && $exception->hasErrors()) {
            throw $exception;
        }

        return $entry;
    }

    /**
     * Validates a property
     * @param string $property Name of the property
     * @param mixed $value Value for the property
     * @return mixed Filtered and validated value
     * @throws \ride\library\validation\exception\ValidationException when the
     * property could not be validated and no exception is provided
     */
    public function validateProperty($property, $value, ValidationException $exception = null) {
        if (isset($this->filters[$property])) {
            foreach ($this->filters[$property] as $filter) {
                $value = $filter->filter();
            }
        }

        if (!isset($this->validators[$property])) {
            return $value;
        }

        if ($exception) {
            $throwException = false;
        } else {
<<<<<<< HEAD
            $throwException = true;

            $exception = new ValidationException();
=======
            $exception = new ValidationException();
            $throwException = true;
>>>>>>> 098665d52ca53d09a50fc4e83b751dadbfaad382
        }

        foreach ($this->validators[$property] as $validator) {
            if ($validator->isValid($value)) {
                continue;
            }

            $exception->addErrors($property, $validator->getErrors());
        }

        if ($throwException && $exception->hasErrors()) {
            throw $exception;
        }

        return $value;
    }

}

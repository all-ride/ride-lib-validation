<?php

namespace pallo\library\validation\constraint;

use pallo\library\validation\exception\ValidationException;
use pallo\library\validation\filter\Filter;
use pallo\library\validation\validator\Validator;

/**
 * Constraint to validate a data container
 */
class GenericConstraint extends AbstractConstraint {

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
    public function __construct() {
        $this->filters = array();
        $this->validators = array();
        $this->constraints = array();
    }

    /**
     * Adds a filter for the provided property
     * @param pallo\library\validation\filter\Filter $filter Filter for the
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
     * @param pallo\library\validation\validator\Validator $validator Validator
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
     * Validates the provided data
     * @param array|object $data Data to be validated
     * @param pallo\library\validation\exception\ValidationException $exception
     * @return array|object Filtered and validated data
     * @throws pallo\library\validation\exception\ValidationException when the
     * data could not be validated and no exception is provided
     */
    public function validateData($data, ValidationException $exception = null) {
        foreach ($this->filters as $property => $filters) {
            $value = $this->getProperty($property, $data);

            if ($value === null) {
                continue;
            }

            foreach ($filters as $filter) {
                $value = $filter->filter($value);
            }

            $this->setProperty($property, $data, $value);
        }

        if ($exception) {
            $throwException = false;
        } else {
            $exception = new ValidationException();
            $throwException = true;
        }

        foreach ($this->validators as $property => $validators) {
            $value = $this->getProperty($property, $data);

            foreach ($validators as $validator) {
                if ($validator->isValid($value)) {
                    continue;
                }

                $exception->addErrors($property, $validator->getErrors());
            }
        }

        foreach ($this->constraints as $constraint) {
            $data = $constraint->validateData($data, $exception);
        }

        if ($throwException && $exception->hasErrors()) {
            throw $exception;
        }

        return $data;
    }

    /**
     * Validates a property
     * @param string $property Name of the property
     * @param mixed $value Value for the property
     * @return mixed Filtered and validated value
     * @throws pallo\library\validation\exception\ValidationException when the
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
            $exception = new ValidationException();
            $throwException = true;
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
<?php

namespace ride\library\validation\constraint;

use ride\library\validation\exception\ValidationException;

/**
 * Constraint to validate a data container
 */
class ConditionalConstraint extends GenericConstraint  {

    protected $conditions;

    public function addValueCondition($property, $value) {
        if (!isset($this->conditions[$property])) {
            $this->conditions[$property] = array();
        }

        $this->conditions[$property][] = $value;
    }

    /**
     * Validates the provided data
     * @param array|object $data Data to be validated
     * @param ride\library\validation\exception\ValidationException $exception
     * @return array|object Filtered and validated data
     * @throws ride\library\validation\exception\ValidationException when the
     * data could not be validated and no exception is provided
     */
    public function validateData($data, ValidationException $exception = null) {
        foreach ($this->conditions as $property => $conditions) {
            $value = $this->getProperty($property, $data);

            foreach ($conditions as $conditionValue) {
                if ($value == $conditionValue) {
                    break 2;
                }
            }

            return $data;
        }

        return parent::validateData($data, $exception);
    }

}
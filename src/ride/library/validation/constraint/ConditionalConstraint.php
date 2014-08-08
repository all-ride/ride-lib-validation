<?php

namespace ride\library\validation\constraint;

use ride\library\validation\exception\ValidationException;

/**
 * Constraint to validate a data container
 */
class ConditionalConstraint extends GenericConstraint  {

    /**
     * Values of the conditional properties which need to match before the
     * constraint is used to validate
     */
    protected $conditions;

    /**
     * Adds a conditional value for a property
     * @param string $property Name of the property
     * @param mixed $value Value for the property which needs to match before
     * the constraint is used to validate
     * @return null
     */
    public function addValueCondition($property, $value) {
        if (!isset($this->conditions[$property])) {
            $this->conditions[$property] = array();
        }

        $this->conditions[$property][] = $value;
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
        foreach ($this->conditions as $property => $conditions) {
            $value = $this->reflectionHelper->getProperty($instance, $property);

            foreach ($conditions as $conditionValue) {
                if ($value === $conditionValue) {
                    break 2;
                }
            }

            return $instance;
        }

        return parent::constrain($instance, $exception);
    }

}

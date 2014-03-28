<?php

namespace ride\library\validation\constraint;

/**
 * Abstract constraint to validate a data container
 */
abstract class AbstractConstraint implements Constraint {

    /**
     * Gets a property of the provided data
     * @param string $property Name of the property
     * @param array|object $data Data container
     * @return mixed Value of the property if found, null otherwise
     */
    protected function getProperty($property, &$data) {
        if (is_array($data)) {
            if (isset($data[$property])) {
                return $data[$property];
            }

            return null;
        }

        $methodName = 'get' . ucfirst($property);
        if (method_exists($data, $methodName)) {
            return $data->$methodName();
        }

        if (isset($data->$property)) {
            return $data->$property;
        }

        return null;
    }

    /**
     * Sets a property to the provided data
     * @param string $property Name of the property
     * @param array|object $data Data container
     * @param mixed $value Value for the property
     * @return null
     */
    protected function setProperty($property, &$data, $value) {
        if (is_array($data)) {
            $data[$property] = $value;

            return;
        }

        $methodName = 'set' . ucfirst($property);
        if (method_exists($data, $methodName)) {
            $data->$methodName($value);
        } else {
            $data->$property = $value;
        }
    }

}
<?php

namespace ride\library\validation\constraint;

use ride\library\validation\exception\ValidationException;

/**
 * Constraint to validate a data container
 */
interface Constraint {

    /**
     * Validates the provided entry
     * @param array|object $entry Entry to be validated
     * @param ride\library\validation\exception\ValidationException $exception
     * @return array|object Filtered and validated entry
     * @throws ride\library\validation\exception\ValidationException when the
     * data could not be validated and no exception is provided
     */
    public function validateEntry($entry, ValidationException $exception = null);

    /**
     * Validates a property
     * @param string $property Name of the property
     * @param mixed $value Value for the property
     * @return mixed Filtered and validated property
     * @throws ride\library\validation\exception\ValidationException when the
     * property could not be validated and no exception is provided
     */
    public function validateProperty($property, $value, ValidationException $exception = null);

}

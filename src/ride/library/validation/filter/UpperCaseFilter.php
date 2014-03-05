<?php

namespace ride\library\validation\filter;

/**
 * Filter to uppercase scalar values
 */
class UpperCaseFilter extends AbstractCaseFilter {

    /**
     * Gets the upper case value
     * @param string $value
     * @return string
     */
    protected function getCaseValue($value) {
        if ($this->mode == self::MODE_NORMAL) {
            return strtoupper($value);
        } elseif ($this->mode == self::MODE_FIRST) {
            return ucfirst($value);
        }

        return ucwords($value);
    }

}
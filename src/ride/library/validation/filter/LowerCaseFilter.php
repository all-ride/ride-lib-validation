<?php

namespace ride\library\validation\filter;

use \RuntimeException;

/**
 * Filter to uppercase scalar values
 */
class LowerCaseFilter extends AbstractCaseFilter {

    /**
     * Gets the upper case value
     * @param string $value
     * @return string
     */
    protected function getCaseValue($value) {
        if ($this->mode == self::MODE_NORMAL) {
            return strtolower($value);
        } elseif ($this->mode == self::MODE_FIRST) {
            return lcfirst($value);
        }

        throw new RuntimeException('Could not lowercase each word: unsupported function');
    }

}
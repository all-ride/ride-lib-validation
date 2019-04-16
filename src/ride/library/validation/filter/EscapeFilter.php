<?php

namespace ride\library\validation\filter;

/**
 * Filter to escape HTML values
 */
class EscapeFilter implements Filter {

    /**
     * Constructs a new filter instance
     * @param array $options Options for this filter
     */
    public function __construct(array $options = null) {

    }

    /**
     * Escapes a scalar value
     * @param mixed $value value to escape
     * @return mixed Escaped value if the provided value was scalar, the
     * original value otherwise
     */
    public function filter($value) {
        if (!is_scalar($value)) {
            return $value;
        }

        return htmlspecialchars($value, ENT_QUOTES);
    }

}

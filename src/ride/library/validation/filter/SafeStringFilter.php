<?php

namespace ride\library\validation\filter;

use ride\library\StringHelper;

/**
 * Interface for a filter. A filter can pre-process a value and fix input
 * errors automatically.
 */
class SafeStringFilter implements Filter {

    /**
     * Name of the replacement option
     * @var string
     */
    const OPTION_REPLACEMENT = 'replacement';

    /**
     * Name of the lower option
     * @var string
     */
    const OPTION_LOWER = 'lower';

    /**
     * Replacement string for the safeString function
     * @var string
     */
    protected $replacement;

    /**
     * Flag to see if the safeSString function should lowercase the value
     * @var boolean
     */
    protected $lower;

    /**
     * Constructs a new filter instance
     * @param array $options Options for this filter
     * @return null
     */
    public function __construct(array $options = null) {
        if (isset($options[self::OPTION_REPLACEMENT])) {
            $this->replacement = $options[self::OPTION_REPLACEMENT];
        } else {
            $this->replacement = '-';
        }

        if (isset($options[self::OPTION_LOWER])) {
            $this->lower = $options[self::OPTION_LOWER];
        } else {
            $this->lower = true;
        }
    }

    /**
     * Filters or decorates a value
     * @param mixed $value The value to filter
     * @return mixed The filtered value if possible, the original value
     * otherwise
     */
    public function filter($value) {
        if (!is_string($value)) {
            return $value;
        }

        return StringHelper::safeString($value, $this->replacement, $this->lower);
    }

}

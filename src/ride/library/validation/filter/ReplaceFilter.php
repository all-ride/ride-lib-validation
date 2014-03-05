<?php

namespace ride\library\validation\filter;

/**
 * Filter to replace parts in scalar values
 */
class ReplaceFilter implements Filter {

    /**
     * Name of the option for the search value
     * @var string
     */
    const OPTION_SEARCH = 'search';

    /**
     * Name of the option for the replace value
     * @var string
     */
    const OPTION_REPLACE = 'replace';

    /**
     * Value(s) to search
     * @var string|array
     */
    private $search;

    /**
     * Value to replace the found tokens with
     * @var string|array
     */
    private $replace;

    /**
     * Constructs a new replace instance
     * @param array $options Options for this filter
     * @return null
     */
    public function __construct(array $options = null) {
        if (!isset($options[self::OPTION_SEARCH])) {
            throw new InvalidArgumentException('No search value provided');
        }

        $this->search = $options[self::OPTION_SEARCH];

        if (isset($options[self::OPTION_REPLACE])) {
            $this->replace = $options[self::OPTION_REPLACE];
        } else {
            $this->replace = '';
        }
    }

    /**
     * Replaces tokens in a value
     * @param mixed $value Value to replace
     * @return mixed Value woth the replaced values
     */
    public function filter($value) {
        if (!is_scalar($value)) {
            return $value;
        }

        return str_replace($this->search, $this->replace, $value);
    }

}
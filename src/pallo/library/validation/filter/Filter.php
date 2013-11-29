<?php

namespace pallo\library\validation\filter;

/**
 * Interface for a filter. A filter can pre-process a value and fix input
 * errors automatically.
 */
interface Filter {

    /**
     * Constructs a new filter instance
     * @param array $options Options for this filter
     * @return null
     */
    public function __construct(array $options = null);

    /**
     * Filters or decorates a value
     * @param mixed $value The value to filter
     * @return mixed The filtered value if possible, the original value
     * otherwise
     */
    public function filter($value);

}
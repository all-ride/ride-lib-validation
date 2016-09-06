<?php

namespace ride\library\validation\filter;

/**
 * Filter to trim scalar values
 */
class StripTagsFilter implements Filter {

    /**
     * Name of the option to trim the individual lines of the value
     * @var string
     */
    const OPTION_ALLOWED_TAGS = 'allowedTags';

    /**
     * Set of allowed tags
     * @var string
     */
    private $allowedTags;

    /**
     * Constructs a new filter instance
     * @param array $options Options for this filter
     * @return null
     */
    public function __construct(array $options = null) {
        if (isset($options[self::OPTION_ALLOWED_TAGS])) {
            $this->allowedTags = $options[self::OPTION_ALLOWED_TAGS];
        } else {
            $this->allowedTags = null;
        }
    }

    /**
     * Trims a scalar value
     * @param mixed $value value to trim
     * @return mixed Trimmed value if the provided value was a string, the
     * original value otherwise
     */
    public function filter($value) {
        if (!is_scalar($value)) {
            return $value;
        }

        if ($this->allowedTags) {
            return strip_tags($value, $this->allowedTags);
        }

        return strip_tags($value);
    }

}
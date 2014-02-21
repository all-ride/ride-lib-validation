<?php

namespace ride\library\validation\filter;

/**
 * Filter to trim scalar values
 */
class TrimFilter implements Filter {

    /**
     * Name of the option to trim the individual lines of the value
     * @var string
     */
    const TRIM_LINES = 'trim.lines';

    /**
     * Name of the option to remove empty lines when filtering individual lines
     * @var string
     */
    const TRIM_EMPTY = 'trim.empty';

    /**
     * Flag to see if the individual lines should be trimmed
     * @var boolean
     */
    private $trimLines;

    /**
     * Flag to see if the empty lines should be trimmed
     * @var boolean
     */
    private $trimEmpty;

    /**
     * Constructs a new filter instance
     * @param array $options Options for this filter
     * @return null
     */
    public function __construct(array $options = null) {
        if (isset($options[self::TRIM_LINES])) {
            $this->trimLines = $options[self::TRIM_LINES];
        } else {
            $this->trimLines = false;
        }

        if (isset($options[self::TRIM_EMPTY])) {
            $this->trimEmpty = $options[self::TRIM_EMPTY];
        } else {
            $this->trimEmpty = false;
        }
    }

    /**
     * Trims a scalar value
     * @param mixed $value value to trim
     * @return mixed Trimmed value if the provided value was a string, the
     * original value otherwise
     */
    public function filter($value) {
        if (is_string($value)) {
            if ($this->trimLines) {
                return $this->trimLines($value);
            }

            return trim($value);
        } elseif (is_array($value)) {
            return $this->trimArray($value);
        }

        return $value;
    }

    /**
     * Trims the individual lines of the provided value
     * @param string $value Value to trim
     * @return string Trimmed value
     */
    private function trimLines($value) {
        $lines = explode("\n", $value);

        $value = '';
        foreach ($lines as $line) {
            $line = trim($line);

            if ($this->trimEmpty && $line === '') {
                continue;
            }

            $value .= ($value ? "\n" : '') . $line;
        }

        return $value;
    }

    /**
     * Trims the array from empty values
     * @param array $values Array to trim
     * @return array Trimmed array
     */
    private function trimArray(array $values) {
        foreach ($values as $key => $value) {
            if (empty($value)) {
                unset($values[$key]);

                continue;
            } elseif (!is_string($value)) {
                continue;
            }

            $value = trim($value);

            if ($this->trimEmpty && $value === '') {
                unset($values[$key]);

                continue;
            }

            $values[$key] = $value;
        }

        return $values;
    }

}
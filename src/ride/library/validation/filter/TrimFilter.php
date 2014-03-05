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
    const OPTION_LINES = 'lines';

    /**
     * Name of the option to remove empty lines when filtering individual lines
     * @var string
     */
    const OPTION_EMPTY = 'empty';

    /**
     * Name of the option to trim the left side
     * @var string
     */
    const OPTION_LEFT = 'left';

    /**
     * Name of the option to trim the right side
     * @var string
     */
    const OPTION_RIGHT = 'right';

    /**
     * Name of the option to set the character mask
     * @var string
     */
    const OPTION_MASK = 'mask';

    /**
     * Flag to see if the individual lines should be trimmed
     * @var boolean
     */
    private $willTrimLines;

    /**
     * Flag to see if the empty lines should be trimmed
     * @var boolean
     */
    private $willTrimEmptyLines;

    /**
     * Flag to see if the beginning of the value should be trimmed
     * @var boolean
     */
    private $willTrimLeft;

    /**
     * Flag to see if the end of the value should be trimmed
     * @var boolean
     */
    private $willTrimRight;

    /**
     * Flag to see if the empty lines should be trimmed
     * @var boolean
     */
    private $characterMask;

    /**
     * Constructs a new filter instance
     * @param array $options Options for this filter
     * @return null
     */
    public function __construct(array $options = null) {
        if (isset($options[self::OPTION_LINES])) {
            $this->willTrimLines = $options[self::OPTION_LINES];
        } else {
            $this->willTrimLines = false;
        }

        if (isset($options[self::OPTION_EMPTY])) {
            $this->willTrimEmptyLines = $options[self::OPTION_EMPTY];
        } else {
            $this->willTrimEmptyLines = false;
        }

        if ($options && array_key_exists(self::OPTION_LEFT, $options)) {
            $this->willTrimLeft = $options[self::OPTION_LEFT];
        } else {
            $this->willTrimLeft = true;
        }

        if ($options && array_key_exists(self::OPTION_RIGHT, $options)) {
            $this->willTrimRight = $options[self::OPTION_RIGHT];
        } else {
            $this->willTrimRight = true;
        }

        if (isset($options[self::OPTION_MASK])) {
            $this->characterMask = $options[self::OPTION_MASK];
        } else {
            $this->characterMask = " \t\n\r\0\x0B";
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
            if ($this->willTrimLines) {
                return $this->trimLines($value);
            }

            return $this->trimValue($value);
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
            $line = $this->trimValue($line);

            if ($this->willTrimEmptyLines && $line === '') {
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

            $value = $this->trimValue($value);

            if ($this->willTrimEmptyLines && $value === '') {
                unset($values[$key]);

                continue;
            }

            $values[$key] = $value;
        }

        return $values;
    }

    /**
     * Performs the actual trim operation
     * @param string $value Value to trim
     * @return string Trimmed value
     */
    private function trimValue($value) {
        if ($this->willTrimLeft && $this->willTrimRight) {
            return trim($value, $this->characterMask);
        } elseif ($this->willTrimLeft) {
            return ltrim($value, $this->characterMask);
        }

        return rtrim($value, $this->characterMask);
    }

}
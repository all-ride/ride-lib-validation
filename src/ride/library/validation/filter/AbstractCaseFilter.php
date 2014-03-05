<?php

namespace ride\library\validation\filter;

use \InvalidArgumentException;

/**
 * Abstract filter to lower or uppercase scalar values
 */
abstract class AbstractCaseFilter implements Filter {

    /**
     * Mode to case everything
     */
    const MODE_NORMAL = 'normal';

    /**
     * Mode to case the first character
     */
    const MODE_FIRST = 'first';

    /**
     * Mode to case the first character of each word
     */
    const MODE_WORD = 'word';

    /**
     * Name of the option case mode
     * @var string
     */
    const OPTION_MODE = 'mode';

    /**
     * Mode of the filter
     * @var string
     */
    protected $mode;

    /**
     * Constructs a new case instance
     * @param array $options Options for this filter
     * @return null
     */
    public function __construct(array $options = null) {
        if (isset($options[self::OPTION_MODE])) {
            $this->mode = $options[self::OPTION_MODE];

            if ($this->mode != self::MODE_NORMAL && $this->mode != self::MODE_FIRST && $this->mode != self::MODE_WORD) {
                throw new InvalidArgumentException('Invalid mode provided: try ' . self::MODE_NORMAL . ', ' . self::MODE_FIRST . ' or ' . self::MODE_WORD);
            }
        } else {
            $this->mode = self::MODE_NORMAL;
        }
    }

    /**
     * Handles the cases of a value
     * @param mixed $value Value to case
     * @return mixed Value with cased characters
     */
    public function filter($value) {
        if (is_string($value)) {
            return $this->getCaseValue($value);
        } elseif (is_array($value)) {
            foreach ($value as $i => $v) {
                $value[$i] = $this->filter($v);
            }
        }

        return $value;
    }

    /**
     * Gets the case value
     * @param string $value
     * @return string
     */
    abstract protected function getCaseValue($value);

}
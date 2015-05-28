<?php

namespace ride\library\validation\filter;

/**
 * Filter to remove all non allowed characters
 */
class AllowCharacterFilter implements Filter {

    /**
     * Name of the option for the allowed characters
     * @var string
     */
    const OPTION_CHARACTERS = 'characters';

    /**
     * Allowed characters as array key
     * @var array
     */
    private $characters;

    /**
     * Constructs a new instance
     * @param array $options Options for this filter
     * @return null
     */
    public function __construct(array $options = null) {
        if (!isset($options[self::OPTION_CHARACTERS])) {
            throw new InvalidArgumentException('No allowed characters provided');
        } elseif (!is_string($options[self::OPTION_CHARACTERS])) {
            throw new InvalidArgumentException('Provided allowed characters is not a string');
        }

        $characters = $options[self::OPTION_CHARACTERS];

        $this->characters = array();
        for ($i = 0, $length = strlen($characters); $i < $length; $i++) {
            $this->characters[substr($characters, $i, 1)] = true;
        }
    }

    /**
     * Replaces tokens in a value
     * @param mixed $value Value to replace
     * @return mixed Value woth the replaced values
     */
    public function filter($value) {
        if (!is_string($value)) {
            return $value;
        }

        $result = '';

        for ($i = 0, $length = strlen($value); $i < $length; $i++) {
            $character = substr($value, $i, 1);
            if (isset($this->characters[$character])) {
                $result .= $character;
            }
        }

        return $result;
    }

}

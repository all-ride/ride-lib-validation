<?php

namespace ride\library\validation\validator;

use \InvalidArgumentException;

/**
 * Validator to check the size of a value to the minimum and/or maximum. If the
 * value is an array, it's number of elements will be used. If the value isn't
 * an array, the string length.
 */
class SizeValidator extends NumericValidator {

    /**
     * Code for the error when an array has more elements then the maximum or less elements then the minimum
     * @var string
     */
    const CODE_ARRAY_MINMAX = 'error.validation.minmax.array';

    /**
     * Code for the error when an array has more elements then the maximum
     * @var string
     */
    const CODE_ARRAY_MAXIMUM = 'error.validation.maximum.array';

    /**
     * Code for the error when an array has less elements then the minimum
     * @var string
     */
    const CODE_ARRAY_MINIMUM = 'error.validation.minimum.array';

    /**
     * Code for the error when a string has more characters then the maximum or less characters then the minimum
     * @var string
     */
    const CODE_STRING_MINMAX = 'error.validation.minmax.string';

    /**
     * Code for the error when a string has more characters then the maximum
     * @var string
     */
    const CODE_STRING_MAXIMUM = 'error.validation.maximum.string';

    /**
     * Code for the error when a string has less characters then the minimum
     * @var string
     */
    const CODE_STRING_MINIMUM = 'error.validation.minimum.string';

    /**
     * Code for the error when a object is passed
     * @var string
     */
    const CODE_OBJECT = 'error.validation.object';

    /**
     * Message for the error when an array has less elements then the minimum
     * @var string
     */
    const MESSAGE_ARRAY_MINMAX = 'Field has to have between %minimum% and %maximum% elements';

    /**
     * Message for the error when an array has less elements then the minimum
     * @var string
     */
    const MESSAGE_ARRAY_MAXIMUM = 'Field cannot have more than %maximum% elements';

    /**
     * Message for the error when an array has less elements then the minimum
     * @var string
     */
    const MESSAGE_ARRAY_MINIMUM = 'Field has to have at least %minimum% elements';

    /**
     * Message for the error when a string has less characters then the minimum
     * @var string
     */
    const MESSAGE_STRING_MINMAX = 'Field has to have between %minimum% and %maximum% characters';

    /**
     * Message for the error when a string has less characters then the minimum
     * @var string
     */
    const MESSAGE_STRING_MAXIMUM = 'Field cannot have more than %maximum% characters';

    /**
     * Message for the error when a string has less characters then the minimum
     * @var string
     */
    const MESSAGE_STRING_MINIMUM = 'Field has to have at least %minimum% characters';

    /**
     * Message for the error when a object is passed
     * @var string
     */
    const MESSAGE_OBJECT = 'Field cannot be an object';

    /**
     * Option key for the minimum value
     * @var string
     */
    const OPTION_MINIMUM = 'minimum';

    /**
     * Option key for the maximum value
     * @var string
     */
    const OPTION_MAXIMUM = 'maximum';

    /**
     * Minimal size for the value
     * @var int
     */
    private $minimum;

    /**
     * Maximum size for the value
     * @var int
     */
    private $maximum;

    /**
     * Construct a new size validator instance
     * @param array $options Options for this validator
     * @return null
     * @throws Exception when no minimum or maximum option is provided
     * @throws Exception when no minimum or maximum is not a valid value
     */
    public function __construct(array $options = array()) {
        if (!isset($options[self::OPTION_MINIMUM]) && !isset($options[self::OPTION_MAXIMUM])) {
            throw new InvalidArgumentException('No minimum nor maximum option provided');
        }

        if (isset($options[self::OPTION_MINIMUM])) {
            if (!parent::isValid($options[self::OPTION_MINIMUM])) {
                throw new InvalidArgumentException('Provided minimum is invalid');
            }

            $this->minimum = $options[self::OPTION_MINIMUM];
        }

        if (isset($options[self::OPTION_MAXIMUM])) {
            if (!parent::isValid($options[self::OPTION_MAXIMUM])) {
                throw new InvalidArgumentException('Provided maximum is invalid');
            }

            $this->maximum = $options[self::OPTION_MAXIMUM];
        }
    }

    /**
     * Checks whether the provided value has a valid size
     * @param mixed $value Value to check
     * @return boolean True when the value has a valid size, false otherwise
     */
    public function isValid($value) {
        $this->resetErrors();

        if (is_object($value)) {
            $this->addError(new ValidationError(self::CODE_OBJECT, self::MESSAGE_OBJECT, array('value' => $value)));

            return false;
        }

        if (is_array($value)) {
            $size = count($value);
            $valueIsArray = true;
        } else {
            $size = strlen($value);
            $valueIsArray = false;
        }

        if ($this->minimum != null && $this->maximum != null) {
            if ($size < $this->minimum || $size > $this->maximum) {
                if ($valueIsArray) {
                    $this->addMinMaxArrayError($value);
                } else {
                    $this->addMinMaxStringError($value);
                }

                return false;
            }
        } elseif ($this->minimum != null) {
            if ($size < $this->minimum) {
                if ($valueIsArray) {
                    $this->addMinimumArrayError($value);
                } else {
                    $this->addMinimumStringError($value);
                }

                return false;
            }
        } elseif ($this->maximum != null) {
            if ($size > $this->maximum) {
                if ($valueIsArray) {
                    $this->addMaximumArrayError($value);
                } else {
                    $this->addMaximumStringError($value);
                }

                return false;
            }
        }

        return true;
    }

    /**
     * Add a validation error for a string with too many characters or with not enhough characters
     * @param string $value
     * @return null
     */
    private function addMinMaxStringError($value) {
        $parameters = array(
            'value' => $value,
            'minimum' => $this->minimum,
            'maximum' => $this->maximum,
        );

        $this->addValidationError(self::CODE_STRING_MINMAX, self::MESSAGE_STRING_MINMAX, $parameters);
    }

    /**
     * Add a validation error for a string with too many characters
     * @param string $value
     * @return null
     */
    private function addMaximumStringError($value) {
        $parameters = array(
            'value' => $value,
            'maximum' => $this->maximum,
        );

        $this->addValidationError(self::CODE_STRING_MAXIMUM, self::MESSAGE_STRING_MAXIMUM, $parameters);
    }

    /**
     * Add a validation error for a string with not enhough characters
     * @param string $value
     * @return null
     */
    private function addMinimumStringError($value) {
        $parameters = array(
            'value' => $value,
            'minimum' => $this->minimum,
        );

        $this->addValidationError(self::CODE_STRING_MINIMUM, self::MESSAGE_STRING_MINIMUM, $parameters);
    }

    /**
     * Add a validation error for an array with more elements then allowed or with the minimum not reached
     * @param array $value
     * @return null
     */
    private function addMinMaxArrayError($value) {
        $parameters = array(
            'value' => $value,
            'minimum' => $this->minimum,
            'maximum' => $this->maximum,
        );

        $this->addValidationError(self::CODE_ARRAY_MINMAX, self::MESSAGE_ARRAY_MINMAX, $parameters);
    }

    /**
     * Add a validation error for an array with more elements then allowed
     * @param array $value
     * @return null
     */
    private function addMaximumArrayError($value) {
        $parameters = array(
            'value' => $value,
            'maximum' => $this->maximum,
        );

        $this->addValidationError(self::CODE_ARRAY_MAXIMUM, self::MESSAGE_ARRAY_MAXIMUM, $parameters);
    }

    /**
     * Add a validation error for an array with the minimum number of elements not reached
     * @param array $value
     * @return null
     */
    private function addMinimumArrayError(array $value) {
        $parameters = array(
            'value' => $value,
            'minimum' => $this->minimum,
        );

        $this->addValidationError(self::CODE_ARRAY_MINIMUM , self::MESSAGE_ARRAY_MINIMUM, $parameters);
    }

}
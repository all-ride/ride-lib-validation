<?php

namespace ride\library\validation\validator;

/**
 * Validator to check if a value is numeric
 */
class NumericValidator extends AbstractValidator {

    /**
     * Code of the error when the value is not numeric
     * @var string
     */
    const CODE = 'error.validation.numeric';

    /**
     * Message of the error when the value is not numeric
     * @var string
     */
    const MESSAGE = '%value% is not a numeric value';

    /**
     * Option key to see if a value is required
     * @var string
     */
    const OPTION_REQUIRED = 'required';

    /**
     * Option key for the numeric error value, a translation key is expected
     * in this option
     * @var string
     */
    const OPTION_ERROR_NUMERIC = 'error.numeric';

    /**
     * Flag to see if a value is required
     * @var boolean
     */
    protected $isRequired;

    /**
     * The error code which will be used
     * @var string
     */
    private $errorCode;

    /**
     * Constructs a new numeric validator
     * @param array $options Options for this validator
     * @return null
     */
    public function __construct(array $options = array()) {
        parent::__construct($options);

        if (isset($options[self::OPTION_REQUIRED])) {
            $this->isRequired = $options[self::OPTION_REQUIRED];
        } else {
            $this->isRequired = true;
        }

        if (isset($options[self::OPTION_ERROR_NUMERIC])) {
            $this->errorCode = $options[self::OPTION_ERROR_NUMERIC];
        } else {
            $this->errorCode = self::CODE;
        }
    }

    /**
     * Checks if the value is a numeric value
     * @param mixed $value Value to check
     * @return boolean True if the value is numeric, false otherwise
     */
    public function isValid($value) {
        $this->resetErrors();

        if (!$this->isRequired && empty($value)) {
            return true;
        }

        if (!is_numeric($value)) {
            $parameters = array('value' => $value);

            $this->addValidationError($this->errorCode, self::MESSAGE, $parameters);

            return false;
        }

        return true;
    }

}
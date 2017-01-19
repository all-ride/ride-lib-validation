<?php

namespace ride\library\validation\validator;

use \Exception;
use \InvalidArgumentException;
use \ReflectionClass;

/**
 * Validator to check for a valid PHP class
 */
class JsonValidator extends AbstractValidator {

    /**
     * Machine name of this validator
     * @var string
     */
    const NAME = 'json';

    /**
     * Code for the error when the value is not a valid json string
     * @var string
     */
    const CODE = 'error.validation.json';

    /**
     * Message for the error when the value is not a valid PHP class
     * @var string
     */
    const MESSAGE = '%value% is not valid json: %message%';

    /**
     * Option key to see if a value is required
     * @var string
     */
    const OPTION_REQUIRED = 'required';

    /**
     * Flag to see if a value is required
     * @var boolean
     */
    protected $isRequired;

    /**
     * Constructs a new class validator
     * @param array $options Options for this validator
     * @return null
     * @throws Exception when the regex option is empty or not a string
     */
    public function __construct(array $options = null) {
        parent::__construct($options);

        $this->isRequired = true;
        if (isset($options[self::OPTION_REQUIRED])) {
            $this->isRequired = $options[self::OPTION_REQUIRED];
        }
    }

    /**
     * Checks whether a value matches the regular expression
     * @param mixed $value
     * @return boolean True if the value matches the regular expression or is
     * empty and a value is not required, false otherwise
     */
    public function isValid($value) {
        $this->resetErrors();

        if (!$this->isRequired && empty($value)) {
            return true;
        }

        $result = json_decode($value, true);
        if ($result !== null) {
            return true;
        }

        if (function_exists('json_last_error_msg')) {
            $error = json_last_error_msg();
        } else {
            $error = 'unknown error';
        }

        $parameters = array(
           'value' => $value,
           'message' => $error,
        );

        $this->addValidationError(self::CODE, self::MESSAGE, $parameters);

        return false;
    }

}

<?php

namespace ride\library\validation\validator;

use \InvalidArgumentException;

/**
 * Validator to check if a value matches a regular expression
 */
class RegexValidator extends AbstractValidator {

    /**
     * Machine name of this validator
     * @var string
     */
    const NAME = 'regex';

    /**
     * Code for the error when the regular expression is not matched
     * @var string
     */
    const CODE = 'error.validation.regex';

    /**
     * Option key for the regular expression
     * @var string
     */
    const OPTION_REGEX = 'regex';

    /**
     * Option key to see if a value is required
     * @var string
     */
    const OPTION_REQUIRED = 'required';

    /**
     * Option key to override the code of the regex error message
     * @var string
     */
    const OPTION_ERROR_REGEX = 'error.regex';

    /**
     * Option key to override the code of the required error message
     * @var string
     */
    const OPTION_ERROR_REQUIRED = 'error.required';

    /**
     * Regular expression for this validator
     * @var string
     */
    protected $regex;

    /**
     * Flag to see if a value is required
     * @var boolean
     */
    protected $isRequired;

    /**
     * Code of the error when the regular expression is not matched
     * @var string
     */
    protected $codeRegex;

    /**
     * Message of the error when the regular expression is not matched
     * @var string
     */
    protected $messageRegex;

    /**
     * Code of the error when the required value is empty
     * @var string
     */
    protected $codeRequired;

    /**
     * Message of the error when the required value is empty
     * @var string
     */
    protected $messageRequired;

    /**
     * Constructs a new regular expression validator
     * @param array $options options for this validator
     * @return null
     * @throws Exception when the regex option is empty or not a string
     */
    public function __construct(array $options = null) {
        parent::__construct($options);

        if (!isset($options[self::OPTION_REGEX])) {
            throw new InvalidArgumentException('No regular expression provided through the options. Use option ' . self::OPTION_REGEX);
        }
        if (!is_string($options[self::OPTION_REGEX]) || !$options[self::OPTION_REGEX]) {
            throw new InvalidArgumentException('Provided regular expression is empty or not a string');
        }

        $this->isRequired = true;
        if (isset($options[self::OPTION_REQUIRED])) {
            $this->isRequired = $options[self::OPTION_REQUIRED];
        }

        $this->regex = $options[self::OPTION_REGEX];

        if (isset($options[self::OPTION_ERROR_REGEX])) {
            $this->codeRegex = $options[self::OPTION_ERROR_REGEX];
        } else {
            $this->codeRegex = self::CODE;
        }

        if (isset($options[self::OPTION_ERROR_REQUIRED])) {
            $this->codeRequired = $options[self::OPTION_ERROR_REQUIRED];
        } else {
            $this->codeRequired = RequiredValidator::CODE;
        }

        $this->messageRequired = 'Field is required';
        $this->messageRegex = 'Field does not match ' . $this->regex;
    }

    /**
     * Gets the regular expression of this validator
     * @return string
     */
    public function getRegex() {
        return $this->regex;
    }

    /**
     * Checks whether a value matches the regular expression
     * @param mixed $value Value to check
     * @return boolean True if the value matches the regular expression or is
     * empty and a value is not required, false otherwise
     */
    public function isValid($value) {
        $this->resetErrors();

        if (empty($value)) {
            if ($this->isRequired) {
                $this->addValidationError($this->codeRequired, $this->messageRequired, array());

                return false;
            } else {
                return true;
            }
        }

        if (!preg_match($this->regex, $value)) {
            $parameters = array(
               'value' => $value,
               'regex' => $this->regex,
            );

            $this->addValidationError($this->codeRegex, $this->messageRegex, $parameters);

            return false;
        }

        return true;
    }

}

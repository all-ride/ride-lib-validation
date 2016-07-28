<?php

namespace ride\library\validation\validator;

/**
 * Validator to check if a value is a valid e-mail address
 */
class EmailValidator extends UrlValidator {

    /**
     * Machine name of this validator
     * @var string
     */
    const NAME = 'email';

    /**
     * Code for the error when the value is not a valid e-mail address
     * @var string
     */
    const CODE = 'error.validation.email';

    /**
     * Message for the error when the value is not a valid e-mail address
     * @var string
     */
    const MESSAGE = '%value% is not a valid email address';

    /**
     * Construct a new e-mail address validator
     * @param array $options options for this validator
     * @return null
     */
    public function __construct(array $options = array()) {
        parent::__construct($options);

        $regexEmail = '(' . $this->regexAlphaDigit . '|' . $this->regexSafe . ')+@' . $this->regexHostDomain;
        $this->regex = '/^' . $regexEmail . '$/';

        $this->codeRegex = self::CODE;
        $this->messageRegex = self::MESSAGE;
    }

}

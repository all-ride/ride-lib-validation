<?php

namespace ride\library\validation\validator;

/**
 * Validator to check whether a value is a valid website
 */
class WebsiteValidator extends UrlValidator {

    /**
     * Machine name of this validator
     * @var string
     */
    const NAME = 'website';

    /**
     * Error code when the value is not a valid website
     * @var string
     */
    const CODE = 'error.validation.website';

    /**
     * Error message when the value is not a valid website
     * @var string
     */
    const MESSAGE = '\'%value%\' is not a valid website';

    /**
     * Constructs a new website validator instance
     * @param array $options Options for this validator
     * @return null
     */
    public function __construct(array $options = array()) {
        parent::__construct($options);

        $this->regex = '/^' . $this->regexHttp . '$/';

        $this->codeRegex = self::CODE;
        $this->messageRegex = self::MESSAGE;
    }

}

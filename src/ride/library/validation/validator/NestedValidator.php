<?php

namespace ride\library\validation\validator;

/**
 * Validator to combine multiple validators in one validator
 */
class NestedValidator extends AbstractValidator {

    /**
     * Array with the validators
     * @var array
     */
    private $validators;

    /**
     * Constructs a new validator instance
     * @param array $options options for the validator
     * @return null
     */
    public function __construct(array $options = array()) {
        parent::__construct($options);

        $this->validators = array();
    }

    /**
     * Add a validator to this validator
     * @param Validator $validator
     * @return null
     */
    public function addValidator(Validator $validator) {
        $this->validators[] = $validator;
    }

    /**
     * Check if the value is valid for all the containing validators
     * @param mixed $value
     * @return boolean True if the value is valid for all containing
     * validators, false otherwise
     */
    public function isValid($value) {
        $this->errors = array();

        foreach ($this->validators as $validator) {
            if ($validator->isValid($value)) {
                continue;
            }

            $errors = $validator->getErrors();
            foreach ($errors as $error) {
                $this->addError($error);
            }
        }

        return empty($this->errors);
    }

}
<?php

namespace pallo\library\validation\validator;

/**
 * Validator to check if a value is empty
 */
class RequiredValidator extends AbstractValidator {

    /**
     * Code of the error message when the value is empty
     * @var string
     */
    const CODE = 'error.validation.required';

    /**
     * Message of the error message when the value is empty
     * @var string
     */
    const MESSAGE = 'Field is required';

    /**
     * Option to change the error message when the value is empty, enter a
     * translation key in this option
     * @var string
     */
    const OPTION_ERROR_REQUIRED = 'error.required';

    /**
     * The error code which will be used
     * @var string
     */
    private $errorCode;

    /**
     * Constructs a new required validator
     * @param array $options Options for this validator
     * @return null
     */
    public function __construct(array $options = array()) {
        parent::__construct($options);

        if (isset($options[self::OPTION_ERROR_REQUIRED])) {
            $this->errorCode = $options[self::OPTION_ERROR_REQUIRED];
        } else {
            $this->errorCode = self::CODE;
        }
    }

    /**
     * Checks whether a value is empty
     * @param mixed $value
     * @return boolean True if the value is empty, false otherwise
     */
    public function isValid($value) {
        $this->resetErrors();

        if (is_object($value)) {
            return true;
        }

        if (is_array($value)) {
            if (empty($value)) {
                $this->addValidationError($this->errorCode, self::MESSAGE, array('value' => $value));

                return false;
            }

            return true;
        }

        $isScalar = is_scalar($value);
        if (($isScalar && $value === '') || !$isScalar) {
            $this->addValidationError($this->errorCode, self::MESSAGE, array('value' => $value));

            return false;
        }

        return true;
    }

}
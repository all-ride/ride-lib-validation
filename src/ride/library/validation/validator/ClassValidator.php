<?php

namespace ride\library\validation\validator;

use \Exception;
use \InvalidArgumentException;
use \ReflectionClass;

/**
 * Validator to check for a valid PHP class
 */
class ClassValidator extends AbstractValidator {

    /**
     * Machine name of this validator
     * @var string
     */
    const NAME = 'class';

    /**
     * Code for the error when the value is not a valid PHP class
     * @var string
     */
    const CODE = 'error.validation.class';

    /**
     * Code for the error when the value does not implement the provided
     * interface
     * @var string
     */
    const CODE_IMPLEMENTS = 'error.validation.class.implements';

    /**
     * Code for the error when the value does not extend the provided class
     * @var string
     */
    const CODE_EXTENDS = 'error.validation.class.extends';

    /**
     * Message for the error when the value is not a valid PHP class
     * @var string
     */
    const MESSAGE = '%value% is not a valid PHP class: %message%';

    /**
     * Message for the error when the value does not implement the provided
     * interface
     * @var string
     */
    const MESSAGE_IMPLEMENTS = '%value% does not implement %interface%';

    /**
     * Message for the error when the value does not extend the provided class
     * @var string
     */
    const MESSAGE_EXTENDS = '%value% does not extend %class%';

    /**
     * Option key for the class the value must implement or extend
     * @var string
     */
    const OPTION_CLASS = 'class';

    /**
     * Option key to see if a value is required
     * @var string
     */
    const OPTION_REQUIRED = 'required';

    /**
     * Interface or class the value must implement/extend
     * @var ReflectionClass
     */
    protected $class;

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
    public function __construct(array $options = array()) {
        parent::__construct($options);

        $this->isRequired = true;
        if (isset($options[self::OPTION_REQUIRED])) {
            $this->isRequired = $options[self::OPTION_REQUIRED];
        }

        if (isset($options[self::OPTION_CLASS])) {
            $class = $options[self::OPTION_CLASS];
            try {
                $classReflection = new ReflectionClass($class);
            } catch (Exception $e) {
                throw new InvalidArgumentException('Needed class/interface ' . $class . ' not found', 0, $e);
            }

            $this->class = $classReflection;
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

        try {
            $classReflection = new ReflectionClass($value);
        } catch (Exception $e) {
            $parameters = array(
               'value' => $value,
               'message' => $e->getMessage(),
            );

            $this->addValidationError(self::CODE, self::MESSAGE, $parameters);

            return false;
        }

        if ($this->class) {
            $className = $this->class->getName();

            if ($this->class->isInterface() && !$classReflection->implementsInterface($className)) {
                $parameters = array(
                   'value' => $value,
                   'interface' => $className,
                );

                $this->addValidationError(self::CODE_IMPLEMENTS, self::MESSAGE_IMPLEMENTS, $parameters);

                return false;
            } elseif (!$classReflection->isSubclassOf($className)) {
                $parameters = array(
                   'value' => $value,
                   'class' => $className,
                );

                $this->addValidationError(self::CODE_EXTENDS, self::MESSAGE_EXTENDS, $parameters);

                return false;
            }
        }

        return true;
    }

}

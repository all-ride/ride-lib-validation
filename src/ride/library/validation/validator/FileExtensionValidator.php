<?php

namespace ride\library\validation\validator;

/**
 * Validator to check if a filename has a certain extension
 */
class FileExtensionValidator extends AbstractValidator {

    /**
     * Machine name of this validator
     * @var string
     */
    const NAME = 'extension';

    /**
     * Code of the error when the filename has not a valid extension
     * @var string
     */
    const CODE = 'error.validation.file.extension';

    /**
     * Message of the error when the filename has not a valid extension
     * @var sting
     */
    const MESSAGE = '%value% should have one of the following extensions: %extensions%';

    /**
     * Option key for the extensions
     * @var string
     */
    const OPTION_EXTENSIONS = 'extensions';

    /**
     * Option key to see if a value is required
     * @var string
     */
    const OPTION_REQUIRED = 'required';

    /**
     * Extensions to check
     * @var array
     */
    private $extensions;

    /**
     * Flag to see if a value is required
     * @var boolean
     */
    private $isRequired;

    /**
     * Constructs a new file extension validator
     * @param array $options Options for this validator
     * @return null
     */
    public function __construct(array $options = null) {
        parent::__construct($options);

        $this->extensions = array();
        if (isset($options[self::OPTION_EXTENSIONS])) {
            $extensions = $options[self::OPTION_EXTENSIONS];

            if (!is_array($extensions)) {
                $extensions = explode(',', $options[self::OPTION_EXTENSIONS]);
            }

            foreach ($extensions as $extension) {
                $extension = trim($extension);
                $this->extensions[$extension] = $extension;
            }
        }

        $this->isRequired = true;
        if (isset($options[self::OPTION_REQUIRED])) {
            $this->isRequired = $options[self::OPTION_REQUIRED];
        }
    }

    /**
     * Checks whether the provided value has a valid extension
     * @param mixed $value Value to check
     * @return boolean True when the value has a valid extension, false
     * otherwise
     */
    public function isValid($value) {
        $isEmpty = empty($value);
        if (!$this->isRequired && $isEmpty) {
            return true;
        } elseif ($isEmpty) {
            $this->addValidationError(RequiredValidator::CODE, RequiredValidator::MESSAGE, array());

            return false;
        }

        $extension = $this->getExtension($value);

        if (!$extension || (!empty($this->extensions) && !isset($this->extensions[$extension]))) {
            $parameters = array(
                'value' => $value,
                'extensions' => implode(',', $this->extensions),
            );

            $this->addValidationError(self::CODE, self::MESSAGE, $parameters);

            return false;
        }

        return true;
    }

    /**
     * Gets the extension for the provided value
     * @param string $value
     * @return string
     */
    protected function getExtension($value) {
        $extensionSeparator = strrpos($value, '.');
        if ($extensionSeparator === false) {
            $extension = '';
        } else {
            $extension = strtolower(substr($value, $extensionSeparator + 1));
        }

        return $extension;
    }

}

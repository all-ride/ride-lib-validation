<?php

namespace ride\library\validation\factory;

use ride\library\validation\filter\TrimFilter;
use ride\library\validation\validator\ClassValidator;
use ride\library\validation\validator\DsnValidator;
use ride\library\validation\validator\EmailValidator;
use ride\library\validation\validator\FileExtensionValidator;
use ride\library\validation\validator\MinMaxValidator;
use ride\library\validation\validator\NestedValidator;
use ride\library\validation\validator\NumericValidator;
use ride\library\validation\validator\RegexValidator;
use ride\library\validation\validator\RequiredValidator;
use ride\library\validation\validator\SizeValidator;
use ride\library\validation\validator\UrlValidator;
use ride\library\validation\validator\WebsiteValidator;

use \Exception;

/**
 * Generic factory for filters and validators
 */
class GenericValidationFactory implements ValidationFactory {

    /**
     * Creates a filter
     * @param string $name Machine name of the filter
     * @param array $options Options to construct the filter
     * @return \ride\library\validation\filter\Filter
     */
    public function createFilter($name, array $options) {
        switch ($name) {
            case 'trim':
                $filter = new TrimFilter($options);

                break;
            default:
                throw new Exception('Could not create filter with name ' . $name . ': no filter defined with this name');

                break;
        }

        return $filter;
    }

    /**
     * Creates a validator
     * @param string $name Machine name of the validator
     * @param array $options Options to construct the validator
     * @return \ride\library\validation\validator\Validator
     */
    public function createValidator($name, array $options) {
        switch ($name) {
            case 'class':
                $validator = new ClassValidator($options);

                break;
            case 'dsn':
                $validator = new DsnValidator($options);

                break;
            case 'email':
                $validator = new EmailValidator($options);

                break;
            case 'extension':
                $validator = new FileExtensionValidator($options);

                break;
            case 'minmax':
                $validator = new MinMaxValidator($options);

                break;
            case 'nested':
                $validator = new NestedValidator($options);

                break;
            case 'numeric':
                $validator = new NumericValidator($options);

                break;
            case 'regex':
                $validator = new RegexValidator($options);

                break;
            case 'required':
                $validator = new RequiredValidator($options);

                break;
            case 'size':
                $validator = new SizeValidator($options);

                break;
            case 'url':
                $validator = new UrlValidator($options);

                break;
            case 'website':
                $validator = new WebsiteValidator($options);

                break;
            default:
                throw new Exception('Could not create validator with name ' . $name . ': no validator defined with this name');

                break;
        }

        return $validator;

    }

}
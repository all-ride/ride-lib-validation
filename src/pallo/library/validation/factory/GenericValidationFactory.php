<?php

namespace pallo\library\validation\factory;

use pallo\library\validation\filter\TrimFilter;
use pallo\library\validation\validator\ClassValidator;
use pallo\library\validation\validator\DsnValidator;
use pallo\library\validation\validator\EmailValidator;
use pallo\library\validation\validator\FileExtensionValidator;
use pallo\library\validation\validator\MinMaxValidator;
use pallo\library\validation\validator\NestedValidator;
use pallo\library\validation\validator\NumericValidator;
use pallo\library\validation\validator\RegexValidator;
use pallo\library\validation\validator\RequiredValidator;
use pallo\library\validation\validator\SizeValidator;
use pallo\library\validation\validator\UrlValidator;
use pallo\library\validation\validator\WebsiteValidator;

use \Exception;

/**
 * Generic factory for filters and validators
 */
class GenericValidationFactory implements ValidationFactory {

    /**
     * Creates a filter
     * @param string $name Machine name of the filter
     * @param array $options Options to construct the filter
     * @return pallo\library\validation\filter\Filter
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
     * @return pallo\library\validation\validator\Validator
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
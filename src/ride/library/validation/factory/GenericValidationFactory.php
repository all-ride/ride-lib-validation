<?php

namespace ride\library\validation\factory;

use ride\library\validation\constraint\ChainConstraint;
use ride\library\validation\constraint\ConditionalConstraint;
use ride\library\validation\constraint\EqualsConstraint;
use ride\library\validation\constraint\GenericConstraint;
use ride\library\validation\constraint\OrConstraint;
use ride\library\validation\filter\AllowCharacterFilter;
use ride\library\validation\filter\LowerCaseFilter;
use ride\library\validation\filter\ReplaceFilter;
use ride\library\validation\filter\SafeStringFilter;
use ride\library\validation\filter\TrimFilter;
use ride\library\validation\filter\UpperCaseFilter;
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
     * Creates a constraint
     * @param string $name Machine name of the constraint
     * @return \ride\library\validation\constraint\Constraint
     */
    public function createConstraint($name) {
        switch ($name) {
            case 'chain':
                $constraint = new ChainConstraint();

                break;
            case 'conditional':
                $constraint = new ConditionalConstraint();

                break;
            case 'equals':
                $constraint = new EqualsConstraint();

                break;
            case 'generic':
                $constraint = new GenericConstraint();

                break;
            case 'or':
                $constraint = new OrConstraint();

                break;
            default:
                throw new Exception('Could not create constraint with name ' . $name . ': no constraint defined with this name');

                break;
        }

        return $constraint;
    }

    /**
     * Creates a filter
     * @param string $name Machine name of the filter
     * @param array $options Options to construct the filter
     * @return \ride\library\validation\filter\Filter
     */
    public function createFilter($name, array $options) {
        switch ($name) {
            case 'characters':
                $filter = new AllowCharacterFilter($options);

                break;
            case 'lower':
                $filter = new LowerCaseFilter($options);

                break;
            case 'replace':
                $filter = new ReplaceFilter($options);

                break;
            case 'safeString':
                $filter = new SafeStringFilter($options);

                break;
            case 'trim':
                $filter = new TrimFilter($options);

                break;
            case 'upper':
                $filter = new UpperCaseFilter($options);

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

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

use \PHPUnit_Framework_TestCase;

class GenericValidationFactoryTest extends PHPUnit_Framework_TestCase {

    public function setUp() {
        $this->factory = new GenericValidationFactory();
    }

    /**
     * @dataProvider providerCreateConstriant
     */
    public function testCreateConstraint($expected, $name) {
        $result = $this->factory->createConstraint($name);

        $this->assertEquals($expected, $result);
    }

    public function providerCreateConstriant() {
        return array(
            array(new ChainConstraint(), 'chain'),
            array(new ConditionalConstraint(), 'conditional'),
            array(new EqualsConstraint(), 'equals'),
            array(new GenericConstraint(), 'generic'),
            array(new OrConstraint(), 'or'),
        );
    }

    /**
     * @dataProvider providerCreateFilter
     */
    public function testCreateFilter($expected, $name, $options = array()) {
        $result = $this->factory->createFilter($name, $options);

        $this->assertEquals($expected, $result);
    }

    public function providerCreateFilter() {
        return array(
            array(new AllowCharacterFilter(array('characters' => 'abc')), 'characters', array('characters' => 'abc')),
            array(new LowerCaseFilter(), 'lower'),
            array(new ReplaceFilter(array('search' => 'john', 'replace' => 'joe')), 'replace', array('search' => 'john', 'replace' => 'joe')),
            array(new SafeStringFilter(), 'safeString'),
            array(new TrimFilter(), 'trim'),
            array(new UpperCaseFilter(), 'upper'),
        );
    }

    /**
     * @dataProvider providerCreateValidator
     */
    public function testCreateValidator($expected, $name, $options = array()) {
        $result = $this->factory->createValidator($name, $options);

        $this->assertEquals($expected, $result);
    }

    public function providerCreateValidator() {
        return array(
            array(new ClassValidator(array()), 'class'),
            array(new DsnValidator(array()), 'dsn'),
            array(new EmailValidator(array()), 'email'),
            array(new FileExtensionValidator(array()), 'extension'),
            array(new MinMaxValidator(array('minimum' => 5)), 'minmax', array('minimum' => 5)),
            array(new NestedValidator(array()), 'nested'),
            array(new NumericValidator(array()), 'numeric'),
            array(new RegexValidator(array('regex' => '/foo/')), 'regex', array('regex' => '/foo/')),
            array(new RequiredValidator(array()), 'required'),
            array(new SizeValidator(array('maximum' => 15)), 'size', array('maximum' => 15)),
            array(new UrlValidator(array()), 'url'),
            array(new WebsiteValidator(array()), 'website'),
        );
    }

}

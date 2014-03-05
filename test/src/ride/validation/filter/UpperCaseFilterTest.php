<?php

namespace ride\library\validation\filter;

use \PHPUnit_Framework_TestCase;

class UpperCaseFilterTest extends PHPUnit_Framework_TestCase {

    /**
     * @dataProvider providerFilter
     */
    public function testFilter($mode, $value, $expected) {
        $filter = new UpperCaseFilter(array(
            UpperCaseFilter::OPTION_MODE => $mode,
        ));

        $result = $filter->filter($value);

        $this->assertEquals($expected, $result, $value);
    }

    public function providerFilter() {
        return array(
            array('normal', 'My CamelCase Sentence', 'MY CAMELCASE SENTENCE'),
            array('first', 'my camelCase sentence', 'My camelCase sentence'),
            array('word', 'my camelCase sentence', 'My CamelCase Sentence'),
        );
    }

}
<?php

namespace ride\library\validation\filter;

use \PHPUnit_Framework_TestCase;

class SafeStringFilterTest extends PHPUnit_Framework_TestCase {

    /**
     * @dataProvider providerFilter
     */
    public function testFilter($value, $expected, $replacement = null, $lowercase = null) {
        $options = array();
        if ($replacement !== null) {
            $options[SafeStringFilter::OPTION_REPLACEMENT] = $replacement;
        }
        if ($lowercase !== null) {
            $options[SafeStringFilter::OPTION_LOWERCASE] = $lowercase;
        }

        $filter = new SafeStringFilter($options);

        $result = $filter->filter($value);
        $this->assertEquals($expected, $result, $value);
    }

    public function providerFilter() {
        return array(
            array(false, false),
            array(true, true),
            array(456, 456),
            array('0', '0'),
            array($this, $this),
            array('This is a test', 'this-is-a-test'),
        );
    }

}

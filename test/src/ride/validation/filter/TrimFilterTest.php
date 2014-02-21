<?php

namespace ride\library\validation\filter;

use \PHPUnit_Framework_TestCase;

class TrimFilterTest extends PHPUnit_Framework_TestCase {

    /**
     * @dataProvider providerFilter
     */
    public function testFilter($value, $expected) {
        $filter = new TrimFilter();

        $result = $filter->filter($value);
        $this->assertEquals($expected, $result, $value);
    }

    public function providerFilter() {
        return array(
            array(false, false),
            array(true, true),
            array(456, 456),
            array('0', '0'),
            array('info@google.com', 'info@google.com'),
            array('  www.google.com  ', 'www.google.com'),
            array($this, $this),
        );
    }

    /**
     * @dataProvider providerLinesFilter
     */
    public function testLinesFilter($value, $expected) {
        $filter = new TrimFilter(array(TrimFilter::TRIM_LINES => true, TrimFilter::TRIM_EMPTY => true));

        $result = $filter->filter($value);
        $this->assertEquals($expected, $result, $value);
    }

    public function providerLinesFilter() {
        return array(
            array(false, false),
            array(true, true),
            array(456, 456),
            array('0', '0'),
            array('info@google.com', 'info@google.com'),
            array('  www.google.com  ', 'www.google.com'),
            array($this, $this),
            array("   test\n  sentence\n\n with   \n some \n whitespaces\n", "test\nsentence\nwith\nsome\nwhitespaces"),
        );
    }

}
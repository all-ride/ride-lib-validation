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
        $filter = new TrimFilter(array(TrimFilter::OPTION_LINES => true, TrimFilter::OPTION_EMPTY => true));

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

    /**
     * @dataProvider providerLeftFilter
     */
    public function testLeftFilter($value, $expected) {
        $filter = new TrimFilter(array(TrimFilter::OPTION_RIGHT => false));

        $result = $filter->filter($value);
        $this->assertEquals($expected, $result, $value);
    }

    public function providerLeftFilter() {
        return array(
            array(true, true),
            array('info@google.com', 'info@google.com'),
            array('  www.google.com  ', 'www.google.com  '),
        );
    }

    /**
     * @dataProvider providerRightFilter
     */
    public function testRightFilter($value, $expected) {
        $filter = new TrimFilter(array(TrimFilter::OPTION_LEFT => false));

        $result = $filter->filter($value);
        $this->assertEquals($expected, $result, $value);
    }

    public function providerRightFilter() {
        return array(
            array(true, true),
            array('info@google.com', 'info@google.com'),
            array('  www.google.com  ', '  www.google.com'),
        );
    }

    /**
     * @dataProvider providerFilterWithCustomMask
     */
    public function testFilterWithCustomMask($value, $expected) {
        $filter = new TrimFilter(array(TrimFilter::OPTION_MASK => '/'));

        $result = $filter->filter($value);
        $this->assertEquals($expected, $result, $value);
    }

    public function providerFilterWithCustomMask() {
        return array(
            array(true, true),
            array('//info@google.com/', 'info@google.com'),
            array('  www.google.com  ', '  www.google.com  '),
        );
    }

}
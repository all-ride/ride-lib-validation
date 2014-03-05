<?php

namespace ride\library\validation\filter;

use \PHPUnit_Framework_TestCase;

class ReplaceFilterTest extends PHPUnit_Framework_TestCase {

    /**
     * @dataProvider providerFilter
     */
    public function testFilter($search, $replace, $subject, $expected) {
        $filter = new ReplaceFilter(array(
            ReplaceFilter::OPTION_SEARCH => $search,
            ReplaceFilter::OPTION_REPLACE => $replace,
        ));

        $result = $filter->filter($subject);

        $this->assertEquals($expected, $result, $subject);
    }

    public function providerFilter() {
        return array(
            array('test', '', false, false),
            array('test', '', true, true),
            array('test', '', 456, 456),
            array('test', '', $this, $this),
            array('test', '', '0', '0'),
            array('google', 'test', 'info@google.com', 'info@test.com'),
            array(array('info', 'google'), 'test', 'info@google.com', 'test@test.com'),
            array(array('info', 'google'), array('john', 'doe'), 'info@google.com', 'john@doe.com'),
        );
    }

}
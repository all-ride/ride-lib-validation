<?php

namespace ride\library\validation\filter;

use \PHPUnit_Framework_TestCase;

class StripTagsFilterTest extends PHPUnit_Framework_TestCase {

    /**
     * @dataProvider providerFilter
     */
    public function testFilter($value, $expected) {
        $filter = new StripTagsFilter();

        $result = $filter->filter($value);
        $this->assertEquals($expected, $result, $value);
    }

    public function providerFilter() {
        return array(
            array('This is a string', 'This is a string'),
            array('This string contains <div>tags</div>', 'This string contains tags'),
        );
    }

    /**
     * @dataProvider providerFilterWithTags
     */
    public function testFilterWithTags($value, $tag, $expected) {
        $filter = new StripTagsFilter(array(StripTagsFilter::OPTION_ALLOWED_TAGS => $tag ));

        $result = $filter->filter($value, $tag);
        $this->assertEquals($expected, $result, $value);
    }
    
    public function providerFilterWithTags() {
        return array(
            array('This is a string', null, 'This is a string'),
            array('This string contains <br>a break', '<br>', 'This string contains <br>a break'),
            array('This string contains <br>a <strong>break</strong>', '<br><strong>', 'This string contains <br>a <strong>break</strong>'),
            array('This string contains <p><br>a <strong>strong break</strong></p>', '<br><strong>', 'This string contains <br>a <strong>strong break</strong>'),
        );
    }

}
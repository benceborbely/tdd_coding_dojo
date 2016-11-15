<?php
/**
 * Created by PhpStorm.
 * User: bence
 * Date: 2016.11.12.
 * Time: 21:01
 */

namespace Tests\Util;

use Util\JsonToArrayConverter;

class JsonToArrayConverterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var JsonToArrayConverter
     */
    protected $converter;

    public function setUp()
    {
        $this->converter = new JsonToArrayConverter();
    }

    /**
     * @param string $input
     * @param array $expected
     *
     * @dataProvider convertDataProvider
     */
    public function testConvert($input, $expected)
    {
        $this->assertEquals($expected, $this->converter->convert($input));
    }

    /**
     * @return array
     */
    public function convertDataProvider()
    {
        return [
            [
                '{"id":1599, "name":"Bence"}',
                [
                    "id" => 1599,
                    "name" => "Bence",
                ]
            ],
            [
                '{}',
                [
                ]
            ],
        ];
    }
}

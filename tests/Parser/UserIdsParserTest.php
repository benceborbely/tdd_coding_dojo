<?php
/**
 * Created by PhpStorm.
 * User: bence
 * Date: 2016.11.13.
 * Time: 20:03
 */

namespace Tests\Parser;


use Parser\UserIdsParser;

class UserIdsParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var UserIdsParser
     */
    protected $parser;

    public function setUp()
    {
        $this->parser = new UserIdsParser();
    }

    /**
     * @param array $data
     * @param array $expected
     * @throws \Exception
     *
     * @dataProvider parseDataProvider
     */
    public function testParse(array $data, array $expected)
    {
        $this->assertEquals($expected, $this->parser->parse($data));
    }

    /**
     * @return array
     */
    public function parseDataProvider()
    {
        return [
            [
                [
                    'items' => [
                        [
                            'owner' => [
                                'user_id' => 589,
                            ],
                        ],
                        [
                            'owner' => [
                                'user_id' => 58959,
                            ],
                        ]
                    ]
                ],
                [589, 58959],
            ],
        ];
    }

    /**
     * @param array $data
     * @param $exceptionType
     * @param $exceptionMsg
     * @throws \Exception
     *
     * @dataProvider invalidDataProvider
     */
    public function testParseWithInvalidData(array $data, $exceptionType, $exceptionMsg)
    {
        $this->setExpectedException($exceptionType, $exceptionMsg);

        $this->parser->parse($data);
    }

    /**
     * @return array
     */
    public function invalidDataProvider()
    {
        return [
            [
                [],
                '\Exception',
                'Key \'items\' is not set.'
            ],
            [
                [
                    'items' =>
                        [
                            [
                                'asd' => [
                                    'asd' => 589,
                                ],
                            ]
                        ]
                ],
                '\Exception',
                'Key \'owner\' is not set.'
            ],
            [
                [
                    'items' =>
                        [
                            [
                                'owner' => [
                                    'asd' => 589,
                                ],
                            ]
                        ]
                ],
                '\Exception',
                'Key \'user_id\' is not set.'
            ]
        ];
    }
}

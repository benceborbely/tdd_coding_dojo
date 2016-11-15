<?php

namespace Tests\Parser;

use Parser\FirstQuestionIdParser;

/**
 * Class FirstQuestionIdParserTest
 *
 * @author Bence Borbély
 */
class FirstQuestionIdParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FirstQuestionIdParser
     */
    protected $parser;

    public function setUp()
    {
        $this->parser = new FirstQuestionIdParser();
    }

    /**
     * @param array $data
     * @param int $expected
     * @throws \Exception
     *
     * @dataProvider parseDataProvider
     */
    public function testParse(array $data, $expected)
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
                        ['question_id' => 589],
                    ]
                ],
                589
            ],
            [
                [
                    'items' => [
                        ['question_id' => 1245],
                    ]
                ],
                1245
            ]
        ];
    }

    /**
     * @param array $data
     * @param string $exceptionName
     * @param string $exceptionMsg
     * @throws \Exception
     *
     * @dataProvider invalidDataProvider
     */
    public function testParseIfInvalidData(array $data, $exceptionName, $exceptionMsg)
    {
        $this->setExpectedException($exceptionName, $exceptionMsg);

        $this->parser->parse($data);
    }

    /**
     * @return array
     */
    public function invalidDataProvider()
    {
        return [
            [[], '\Exception', 'Key \'items\' is not set.'],
            [['items' => []], '\Exception', 'Empty array.'],
            [[
                'items' => [
                    ['link' => 'https://stackoverflow.com/questions/asd'],
                ],
            ], '\Exception', 'Key \'question_id\' is not set.'],
        ];
    }
}

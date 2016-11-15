<?php

namespace Tests\Repository\Question;

use Repository\ApiQuestionRepository;

/**
 * Class ApiQuestionRepositoryTest
 *
 * @author Bence Borbély
 */
class ApiQuestionRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ApiQuestionRepository
     */
    protected $repository;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $curlMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $converterMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $firstQuestionIdParserMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $userIdsParserMock;

    public function setUp()
    {
        $this->curlMock = $this
            ->getMockBuilder('Util\Curl')
            ->getMock();

        $this->converterMock = $this
            ->getMockBuilder('Util\JsonToArrayConverter')
            ->getMock();

        $this->firstQuestionIdParserMock = $this
            ->getMockBuilder('Parser\FirstQuestionIdParser')
            ->getMock();

        $this->userIdsParserMock = $this
            ->getMockBuilder('Parser\UserIdsParser')
            ->getMock();

        $this->repository = new ApiQuestionRepository($this->curlMock, $this->converterMock, $this->firstQuestionIdParserMock, $this->userIdsParserMock);
    }

    /**
     * @param $json
     * @param $array
     * @throws \Exception
     *
     * @dataProvider getMostPopularDataProvider
     */
    public function testGetMostPopular($json, $array, $expected)
    {
        $this
            ->curlMock
            ->expects($this->once())
            ->method('get')
            ->will($this->returnValue($json));

        $this
            ->converterMock
            ->expects($this->once())
            ->method('convert')
            ->with($json)
            ->will($this->returnValue($array));

        $this
            ->firstQuestionIdParserMock
            ->expects($this->once())
            ->method('parse')
            ->with($array)
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $this->repository->getMostPopularQuestionId());
    }

    /**
     * @return array
     */
    public function getMostPopularDataProvider()
    {
        return [
            [
                '{"items":[{"question_id":589}, {"question_id":58959}]}',
                [
                    'items' => [
                        ['question_id' => 589],
                        ['question_id' => 58959],
                    ]
                ],
                589
            ],
            [
                '{"items":[{"question_id":488}]}',
                [
                    'items' => [
                        ['question_id' => 488],
                    ]
                ],
                488
            ],
        ];
    }

    public function testGetMostPopularIfExceptionThrown()
    {
        $json = '{}';
        $array = [];

        $this
            ->curlMock
            ->expects($this->once())
            ->method('get')
            ->will($this->returnValue('{}'));

        $this
            ->converterMock
            ->expects($this->once())
            ->method('convert')
            ->with($json)
            ->will($this->returnValue($array));

        $this
            ->firstQuestionIdParserMock
            ->expects($this->once())
            ->method('parse')
            ->with($array)
            ->willThrowException(new \Exception('Key \'question_id\' is not set.'));

        $this->assertEquals(0, $this->repository->getMostPopularQuestionId());
    }

    /**
     * @param string $json
     * @param array $array
     * @param array $expected
     * @throws \Exception
     *
     * @dataProvider userIdsOfAnswersOfAQuestionDataProvider
     */
    public function testGetUserIdsOfAnswersOfAQuestion($json, array $array, array $expected)
    {
        $this
            ->curlMock
            ->expects($this->once())
            ->method('get')
            ->will($this->returnValue($json));

        $this
            ->converterMock
            ->expects($this->once())
            ->method('convert')
            ->with($json)
            ->will($this->returnValue($array));

        $this
            ->userIdsParserMock
            ->expects($this->once())
            ->method('parse')
            ->will($this->returnValue($expected));

        $dummyQuestionId = 588;

        $this->assertEquals($expected, $this->repository->getUserIdsOfAnswersOfAQuestion($dummyQuestionId));
    }

    /**
     * @return array
     */
    public function userIdsOfAnswersOfAQuestionDataProvider()
    {
        return [
            [
                '{"items":[{"owner":{"user_id":589}}, {"owner":{"user_id":58959}}]}',
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

    public function testGetUserIdsOfAnswersOfAQuestionIfExceptionThrown()
    {
        $json = '{}';
        $array = [];

        $this
            ->curlMock
            ->expects($this->once())
            ->method('get')
            ->will($this->returnValue($json));

        $this
            ->converterMock
            ->expects($this->once())
            ->method('convert')
            ->with($json)
            ->will($this->returnValue($array));

        $this
            ->userIdsParserMock
            ->expects($this->once())
            ->method('parse')
            ->willThrowException(new \Exception('Key \'items\' is not set.'));

        $dummyQuestionId = 588;

        $this->assertEquals([], $this->repository->getUserIdsOfAnswersOfAQuestion($dummyQuestionId));
    }
}

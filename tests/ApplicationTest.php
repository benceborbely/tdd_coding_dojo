<?php

/**
 * Class ApplicationTest
 *
 * @author Bence Borbély
 */
class ApplicationTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Application
     */
    protected $application;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $repositoryMock;

    public function setUp()
    {
        $this->repositoryMock = $this
            ->getMockBuilder('Repository\ApiQuestionRepository')
            ->disableOriginalConstructor()
            ->getMock();

        $this->application = new Application($this->repositoryMock);
    }

    /**
     * @param array $expected
     *
     * @dataProvider runDataProvider
     */
    public function testRun(array $expected)
    {
        $dummyQuestionId = 50;

        $this
            ->repositoryMock
            ->expects($this->once())
            ->method('getMostPopularQuestionId')
            ->will($this->returnValue($dummyQuestionId));

        $this
            ->repositoryMock
            ->expects($this->once())
            ->method('getUserIdsOfAnswersOfAQuestion')
            ->with($dummyQuestionId)
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $this->application->run());
    }

    /**
     * @return array
     */
    public function runDataProvider()
    {
        return [
            [[50, 105]],
            [[899, 544]]
        ];
    }
}

<?php

namespace Repository;

use Parser\FirstQuestionIdParser;
use Parser\UserIdsParser;
use Util\JsonToArrayConverter;
use Util\Curl;

/**
 * Class ApiQuestionRepository
 *
 * @author Bence Borbély
 */
class ApiQuestionRepository implements QuestionRepositoryInterface
{
    /**
     * @var string
     */
    protected $url = 'https://api.stackexchange.com/2.2/questions/';

    /**
     * @var Curl
     */
    protected $curl;

    /**
     * @var JsonToArrayConverter
     */
    protected $converter;

    /**
     * @var FirstQuestionIdParser
     */
    protected $firstQuestionIdParser;

    /**
     * @var UserIdsParser
     */
    protected $userIdsParser;

    /**
     * @param Curl $curl
     * @param JsonToArrayConverter $converter
     * @param FirstQuestionIdParser $firstQuestionIdParser
     * @param UserIdsParser $userIdsParser
     */
    public function __construct
    (
        Curl $curl,
        JsonToArrayConverter $converter,
        FirstQuestionIdParser $firstQuestionIdParser,
        UserIdsParser $userIdsParser
    )
    {
        $this->curl = $curl;
        $this->converter = $converter;
        $this->firstQuestionIdParser = $firstQuestionIdParser;
        $this->userIdsParser = $userIdsParser;
    }

    /**
     * @return int
     */
    public function getMostPopularQuestionId()
    {
        $url = $this->url . 'featured?order=desc&sort=activity&site=stackoverflow';

        $array = $this->getArray($url);

        try {
            $questionId = $this->firstQuestionIdParser->parse($array);
        } catch (\Exception $e) {
            //TODO logging exception
            $questionId = 0;
        }

        return $questionId;
    }

    /**
     * @param int $questionId
     * @return array
     */
    public function getUserIdsOfAnswersOfAQuestion($questionId)
    {
        $url = $this->url . $questionId . '/answers?site=stackoverflow';

        $array = $this->getArray($url);

        try {
            $userIds = $this->userIdsParser->parse($array);
        } catch (\Exception $e) {
            //TODO logging exception
            $userIds = [];
        }

        return $userIds;
    }

    /**
     * @param string $url
     * @return array
     */
    protected function getArray($url)
    {
        $json = $this->curl->get($url);

        return $this->converter->convert($json);
    }
}

<?php

namespace Parser;

/**
 * Class FirstQuestionIdParser
 *
 * @author Bence Borbély
 */
class FirstQuestionIdParser
{
    /**
     * @param array $data
     * @return int
     * @throws \Exception
     */
    public function parse(array $data)
    {
        if (!isset($data['items'])) {
            throw new \Exception('Key \'items\' is not set.');
        }

        if (!isset($data['items'][0])) {
            throw new \Exception('Empty array.');
        }

        if (!isset($data['items'][0]['question_id'])) {
            throw new \Exception('Key \'question_id\' is not set.');
        }

        return $data['items'][0]['question_id'];
    }
}

<?php

namespace Parser;

/**
 * Class UserIdsParser
 *
 * @author Bence Borbély
 */
class UserIdsParser
{
    /**
     * @param array $data
     * @return array
     * @throws \Exception
     */
    public function parse(array $data)
    {
        if (!isset($data['items'])) {
            throw new \Exception('Key \'items\' is not set.');
        }

        $userIds = [];

        foreach ($data['items'] as $key => $answer) {
            if (!isset($data['items'][$key]['owner'])) {
                throw new \Exception('Key \'owner\' is not set.');
            }

            if (!isset($data['items'][$key]['owner']['user_id'])) {
                throw new \Exception('Key \'user_id\' is not set.');
            }

            $userIds[] = $data['items'][$key]['owner']['user_id'];
        }

        return $userIds;
    }
}

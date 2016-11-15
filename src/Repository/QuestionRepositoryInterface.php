<?php

namespace Repository;

/**
 * Interface QuestionRepositoryInterface
 *
 * @author Bence Borbély
 */
interface QuestionRepositoryInterface
{
    /**
     * @return int
     */
    public function getMostPopularQuestionId();

    /**
     * @param int $questionId
     * @return array
     */
    public function getUserIdsOfAnswersOfAQuestion($questionId);
}

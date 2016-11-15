<?php

use \Repository\QuestionRepositoryInterface;

/**
 * Class Application
 *
 * @author Bence Borbély
 */
class Application
{
    /**
     * @var QuestionRepositoryInterface
     */
    protected $repository;

    /**
     * @param QuestionRepositoryInterface $repository
     */
    public function __construct(\Repository\QuestionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return array
     */
    public function run()
    {
        $questionId = $this->repository->getMostPopularQuestionId();

        return $this->repository->getUserIdsOfAnswersOfAQuestion($questionId);
    }
}

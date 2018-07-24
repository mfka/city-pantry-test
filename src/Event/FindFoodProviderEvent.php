<?php

namespace App\Event;

use App\Model\ArgumentsModel;
use Symfony\Component\EventDispatcher\Event;

class FindFoodProviderEvent extends Event
{
    public const NAME = 'find.food.provider';

    /** @var ArgumentsModel */
    protected $arguments;

    /** @var string */
    protected $filePath;

    /** @var array */
    protected $results;

    public function __construct(string $filePath, ArgumentsModel $arguments)
    {
        $this->filePath = $filePath;
        $this->arguments = $arguments;
    }

    public function getArguments(): ArgumentsModel
    {
        return $this->arguments;
    }

    public function getFilePath(): string
    {
        return $this->filePath;
    }

    public function getResults(): array
    {
        return $this->results;
    }

    public function setResults(array $results): void
    {
        $this->results = $results;
    }

}
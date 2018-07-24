<?php

namespace App\Command;

class SearchCommand
{
    /** @var string */
    private $filePath;
    /** @var string */
    private $day;
    /** @var string */
    private $time;
    /** @var string */
    private $location;
    /** @var int */
    private $cover;

    public function __construct(string $filePath, string $day, string $time, string $location, int $cover)
    {
        $this->filePath = $filePath;
        $this->day = $day;
        $this->time = $time;
        $this->location = $location;
        $this->cover = $cover;
    }

    public function getFilePath(): string
    {
        return $this->filePath;
    }

    public function getDay(): string
    {
        return $this->day;
    }

    public function getTime(): string
    {
        return $this->time;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function getCover(): int
    {
        return $this->cover;
    }
}

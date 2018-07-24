<?php

namespace App\Model;

/**
 * @codeCoverageIgnore
 */
class ArgumentsModel
{
    /**
     * @var \DateTime
     */
    private $date;
    /**
     * @var \DateTime
     */
    private $time;
    /**
     * @var string
     */
    private $location;
    /**
     * @var int
     */
    private $cover;

    public function __construct(string $day, string $time, string $location, int $cover)
    {
        $this->date = \DateTime::createFromFormat('d/m/y H:i', $day.' '.$time);
        $this->location = $location;
        $this->cover = $cover;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): void
    {
        $this->date = $date;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function setLocation(string $location): void
    {
        $this->location = $location;
    }

    public function getCover(): int
    {
        return $this->cover;
    }

    public function setCover(int $cover): void
    {
        $this->cover = $cover;
    }
}

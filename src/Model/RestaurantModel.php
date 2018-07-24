<?php

namespace App\Model;

/**
 * @codeCoverageIgnore
 */
class RestaurantModel
{
    /** @var string */
    private $name;
    /** @var string */
    private $postal;
    /** @var int */
    private $coverage;
    /** @var array<MealModel> */
    private $meals;
    /** @var bool */
    private $valid;

    public function __construct(string $name, string $postal, int $coverage)
    {
        $this->name = $name;
        $this->postal = $postal;
        $this->coverage = $coverage;
        $this->meals = [];
        $this->valid = false;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPostal(): string
    {
        return $this->postal;
    }

    public function setPostal(string $postal): self
    {
        $this->postal = $postal;

        return $this;
    }

    public function getCoverage(): int
    {
        return $this->coverage;
    }

    public function setCoverage(int $coverage): self
    {
        $this->coverage = $coverage;

        return $this;
    }

    public function addMeal(MealModel $meal): self
    {
        $this->meals[] = $meal;

        return $this;
    }

    public function getMeals(): array
    {
        return $this->meals;
    }

    public function setMeals(array $meals): self
    {
        $this->meals = $meals;

        return $this;
    }

    public function hasMeal(): bool
    {
        return (bool)\count($this->getMeals()) > 0;
    }

    public function setValid(bool $valid): self
    {
        $this->valid = $valid;

        return $this;
    }

    public function isValid(): bool
    {
        return $this->valid;
    }
}

<?php


namespace App\Model;

/**
 * @codeCoverageIgnore
 */
class MealModel
{
    /** @var string */
    private $name;
    /** @var array */
    private $allergens;
    /** @var int */
    private $preparationTime;
    /** @var bool */
    private $valid;

    public function __construct(string $name, array $allergens, int $preparationTime)
    {
        $this->name = $name;
        $this->allergens = $allergens;
        $this->preparationTime = $preparationTime;
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

    public function getAllergens(): array
    {
        return $this->allergens;
    }

    public function getAllergensAsString(): string
    {
        return implode(',', $this->getAllergens());
    }

    public function setAllergens(array $allergens): self
    {
        $this->allergens = $allergens;

        return $this;
    }

    public function getPreparationTime(): int
    {
        return $this->preparationTime;
    }

    public function setPreparationTime(int $preparationTime): self
    {
        $this->preparationTime = $preparationTime;

        return $this;
    }

    public function getWhenMealCanBeReady(): \DateTime
    {
        return new \DateTime(sprintf('+ %d hour', $this->getPreparationTime()));
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
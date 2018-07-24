<?php

namespace App\Event;

use App\Model\ArgumentsModel;
use App\Model\MealModel;
use App\Model\RestaurantModel;
use Symfony\Component\EventDispatcher\Event;

class ValidateMealEvent extends Event
{
    public const NAME = 'validate.meal';
    /**
     * @var MealModel
     */
    private $meal;
    /**
     * @var ArgumentsModel
     */
    private $arguments;

    public function __construct(MealModel $meal, ArgumentsModel $arguments)
    {
        $this->meal = $meal;
        $this->arguments = $arguments;
    }

    public function getMeal(): MealModel
    {
        return $this->meal;
    }

    public function getArguments(): ArgumentsModel
    {
        return $this->arguments;
    }
}
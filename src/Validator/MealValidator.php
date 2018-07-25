<?php

namespace App\Validator;

use App\Model\ArgumentsModel;
use App\Model\MealModel;

class MealValidator
{
    public function validate(MealModel $meal, ArgumentsModel $arguments): void
    {
        switch (true) {
            case($arguments->getDate() <= $meal->getWhenMealCanBeReady()):
                break;
            default:
                $meal->setValid(true);
                break;
        }
    }
}
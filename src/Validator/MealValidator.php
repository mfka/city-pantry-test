<?php

namespace App\Validator;

use App\Model\ArgumentsModel;
use App\Model\MealModel;

class MealValidator
{
    public function validate(MealModel $meal, ArgumentsModel $arguments): bool
    {
        switch (true) {
            case($arguments->getDate() <= $meal->getWhenMealCanBeReady()):
                return false;
                break;
            default:
                return true;
        }
    }
}
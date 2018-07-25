<?php

namespace App\Service;

use App\Model\ArgumentsModel;
use App\Model\MealModel;
use App\Validator\MealValidator;

class MealCreator
{
    /** @var MealValidator */
    private $validator;

    public function __construct(MealValidator $validator)
    {
        $this->validator = $validator;
    }

    public function create(array $data, ArgumentsModel $arguments): MealModel
    {
        $meal = new MealModel(trim($data[0]), array_filter(explode(',', $data[1])), (int)$data[2]);
        $this->validator->validate($meal, $arguments);

        return $meal;
    }
}
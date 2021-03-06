<?php

namespace App\Service;

use App\Model\ArgumentsModel;
use App\Model\RestaurantModel;
use App\Validator\RestaurantValidator;
use Symfony\Component\Validator\Exception\ValidatorException;

class RestaurantCreator
{
    /** @var RestaurantValidator */
    private $validator;

    public function __construct(RestaurantValidator $validator)
    {
        $this->validator = $validator;
    }

    public function create(array $data, ArgumentsModel $arguments): RestaurantModel
    {
        try {
            $restaurant = new RestaurantModel(trim($data[0]), trim($data[1]), (int)$data[2]);
            $this->validator->validate($restaurant, $arguments);

            return $restaurant;
        } catch (\Exception $exception) {
            throw new ValidatorException('Could not create Restaurant. Invalid vendor line: '.implode(';', $data));
        }

    }
}
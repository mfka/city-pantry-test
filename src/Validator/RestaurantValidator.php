<?php

namespace App\Validator;

use App\Model\ArgumentsModel;
use App\Model\RestaurantModel;

class RestaurantValidator
{
    public function validate(RestaurantModel $restaurant, ArgumentsModel $arguments): bool
    {
        switch (true) {
            case ($restaurant->getCoverage() < $arguments->getCover()):
                return false;
            case (!$this->comparePostal($restaurant->getPostal(), $arguments->getLocation())):
                return false;
            default:
                return true;
        }
    }

    private function comparePostal(string $postalOne, string $postalTwo): bool
    {
        preg_match('/^[A-Za-z]{1,}/m', $postalOne, $matchesOne);
        preg_match('/^[A-Za-z]{1,}/m', $postalTwo, $matchesTwo);

        return $matchesOne[0] === $matchesTwo[0];
    }
}
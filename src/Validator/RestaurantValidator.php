<?php

namespace App\Validator;

use App\Model\ArgumentsModel;
use App\Model\RestaurantModel;

class RestaurantValidator
{
    public function validate(RestaurantModel $restaurant, ArgumentsModel $arguments): void
    {
        switch (true) {
            case ($restaurant->getCoverage() < $arguments->getCover()):
                break;
            case (!$this->comparePostal($restaurant->getPostal(), $arguments->getLocation())):
                break;
            default:
                $restaurant->setValid(true);
                break;
        }
    }

    private function comparePostal(string $postalOne, string $postalTwo): bool
    {
        preg_match('/^[A-Za-z]{1,}/m', $postalOne, $matchesOne);
        preg_match('/^[A-Za-z]{1,}/m', $postalTwo, $matchesTwo);

        return $matchesOne[0] === $matchesTwo[0];
    }
}
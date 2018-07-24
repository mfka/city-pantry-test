<?php

namespace App\Event;

use App\Model\ArgumentsModel;
use App\Model\RestaurantModel;
use Symfony\Component\EventDispatcher\Event;

class ValidateRestaurantEvent extends Event
{
    public const NAME = 'validate.restaurant';
    /**
     * @var RestaurantModel
     */
    private $restaurant;
    /**
     * @var ArgumentsModel
     */
    private $arguments;

    public function __construct(RestaurantModel $restaurant, ArgumentsModel $arguments)
    {
        $this->restaurant = $restaurant;
        $this->arguments = $arguments;
    }

    public function getRestaurant(): RestaurantModel
    {
        return $this->restaurant;
    }

    public function getArguments(): ArgumentsModel
    {
        return $this->arguments;
    }
}
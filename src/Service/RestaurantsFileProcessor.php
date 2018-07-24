<?php

namespace App\Service;

use App\Event\ValidateMealEvent;
use App\Event\ValidateRestaurantEvent;
use App\Model\ArgumentsModel;
use App\Model\MealModel;
use App\Model\RestaurantModel;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Validator\Exception\ValidatorException;

class RestaurantsFileProcessor
{
    /** @var EventDispatcherInterface */
    private $dispatcher;
    /** @var null | RestaurantModel */
    private $restaurant;
    /** @var array */
    private $results;

    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
        $this->results = [];
    }

    /** To make code nicer I could use Session - but I don't have time :( */
    public function process(string $filePath, ArgumentsModel $arguments): array
    {
        $handle = fopen($filePath, 'r');
        $lineIsRestaurant = true;
        $skipMeals = true;
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                if (!preg_match('/^\s*$/m', $line)) {

                    $row = $this->getRow($line);

                    if (true === $lineIsRestaurant) {
                        $restaurant = new RestaurantModel(trim($row[0]), trim($row[1]), trim($row[2]));

                        if ($this->restaurant !== $restaurant) {
                            $this->savePreviousRestaurant();
                        }

                        $restaurantEvent = new ValidateRestaurantEvent($restaurant, $arguments);
                        $this->dispatcher->dispatch(ValidateRestaurantEvent::NAME, $restaurantEvent);

                        if ($restaurant->isValid()) {
                            $this->restaurant = $restaurant;
                            $skipMeals = false;
                        } else {
                            $skipMeals = true;
                        }

                        $lineIsRestaurant = false;

                    } elseif (false === $skipMeals) {

                        $meal = new MealModel(trim($row[0]), explode(',', $row[1]), (int)$row[2]);
                        $mealEvent = new ValidateMealEvent($meal, $arguments);
                        $this->dispatcher->dispatch(ValidateMealEvent::NAME, $mealEvent);

                        if ($meal->isValid()) {
                            $this->restaurant->addMeal($meal);
                        }
                    }
                }
                if (preg_match('/^\s*$/m', $line)) {
                    $lineIsRestaurant = true;
                }
            }
            $this->savePreviousRestaurant();
            fclose($handle);
        }
        return $this->results;

    }

    private function savePreviousRestaurant(): void
    {
        if (null !== $this->restaurant && $this->restaurant->hasMeal()) {
            $this->results[] = $this->restaurant;
            $this->restaurant = null;
        }
    }

    private function getRow(string $line): array
    {
        $row = explode(';', $line);

        if (\count($row) !== 3) {
            throw new ValidatorException('Incorrect line in file.'.$line);
        }

        return $row;
    }
}

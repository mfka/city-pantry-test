<?php

namespace App\Subscriber;

use App\Event\VendorFoundEvent;
use App\Model\RestaurantModel;
use App\Service\MealCreator;
use App\Service\RestaurantCreator;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class VendorSubscriber implements EventSubscriberInterface
{
    /** @var RestaurantCreator */
    private $restaurantCreator;
    /** @var RestaurantModel */
    private $restaurant;
    /** @var MealCreator */
    private $mealCreator;

    public function __construct(RestaurantCreator $restaurantCreator, MealCreator $mealCreator)
    {
        $this->restaurantCreator = $restaurantCreator;
        $this->restaurant = [];
        $this->mealCreator = $mealCreator;
    }

    public static function getSubscribedEvents(): array
    {
        return [VendorFoundEvent::NAME => 'onVendorFound'];
    }

    public function onVendorFound(VendorFoundEvent $event): void
    {
        $output = new ConsoleOutput();
        $vendor = $event->getVendor();
        foreach ($vendor as $iteration => $value) {
            if ($iteration === key($vendor)) {
                $this->restaurant = $this->restaurantCreator->create($value, $event->getArguments());
                continue;
            }
            if (false === $this->restaurant->isValid()) {
                continue;
            }
            $meal = $this->mealCreator->create($value, $event->getArguments());
            if ($meal->isValid()) {
                $output->writeln(
                    sprintf(
                        '%s;%s',
                        $meal->getName(),
                        \count($meal->getAllergens()) === 0 ? ';' : implode(',', $meal->getAllergens())
                    )
                );
            }
        }
    }
}
<?php

namespace App\Subscriber;

use App\Event\ValidateRestaurantEvent;
use App\Validator\RestaurantValidator;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class RestaurantSubscriber implements EventSubscriberInterface
{
    /**
     * @var RestaurantValidator
     */
    private $validator;

    public function __construct(RestaurantValidator $validator)
    {
        $this->validator = $validator;
    }

    public function validateRestaurant(ValidateRestaurantEvent $event): void
    {
        $valid = $this->validator->validate($event->getRestaurant(), $event->getArguments());
        $event->getRestaurant()->setValid($valid);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ValidateRestaurantEvent::NAME => 'validateRestaurant',
        ];
    }
}

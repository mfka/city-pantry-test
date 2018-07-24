<?php

namespace App\Subscriber;

use App\Event\ValidateMealEvent;
use App\Event\ValidateRestaurantEvent;
use App\Validator\MealValidator;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MealSubscriber implements EventSubscriberInterface
{
    /**
     * @var MealValidator
     */
    private $validator;

    public function __construct(MealValidator $validator)
    {
        $this->validator = $validator;
    }

    public function validateMeal(ValidateMealEvent $event): void
    {
        $valid = $this->validator->validate($event->getMeal(), $event->getArguments());
        $event->getMeal()->setValid($valid);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ValidateMealEvent::NAME => 'validateMeal',
        ];
    }
}

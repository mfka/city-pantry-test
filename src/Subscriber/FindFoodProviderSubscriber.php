<?php

namespace App\Subscriber;

use App\Event\FindFoodProviderEvent;
use App\Service\RestaurantsFileProcessor;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


class FindFoodProviderSubscriber implements EventSubscriberInterface
{
    /** @var RestaurantsFileProcessor */
    private $fileProcessor;

    public function __construct(RestaurantsFileProcessor $fileProcessor)
    {
        $this->fileProcessor = $fileProcessor;
    }

    public function findMeals(FindFoodProviderEvent $event): void
    {
        $results = $this->fileProcessor->process($event->getFilePath(), $event->getArguments());
        $event->setResults($results);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            FindFoodProviderEvent::NAME => 'findMeals',
        ];
    }
}
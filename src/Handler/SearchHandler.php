<?php

namespace App\Handler;

use App\Command\SearchCommand;
use App\Event\FindFoodProviderEvent;
use App\Model\ArgumentsModel;
use App\Model\MealModel;
use App\Model\RestaurantModel;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SearchHandler
{
    /** @var ValidatorInterface */
    private $validator;

    /** @var EventDispatcherInterface */
    private $dispatcher;

    public function __construct(ValidatorInterface $validator, EventDispatcherInterface $dispatcher)
    {
        $this->validator = $validator;
        $this->dispatcher = $dispatcher;
    }

    public function handle(SearchCommand $command): void
    {
        if ($this->validate($command)) {

            $arguments = new ArgumentsModel(
                $command->getDay(),
                $command->getTime(),
                $command->getLocation(),
                $command->getCover()
            );

            $event = new FindFoodProviderEvent($command->getFilePath(), $arguments);
            $this->dispatcher->dispatch(FindFoodProviderEvent::NAME, $event);

            $output = new ConsoleOutput();
            /** @var RestaurantModel $restaurant */
            foreach ($event->getResults() as $restaurant) {
                /** @var MealModel $meal */
                foreach ($restaurant->getMeals() as $meal) {
                    $output->writeln(sprintf('%s;%s', $meal->getName(), $meal->getAllergensAsString()));
                }
            }
        }
    }

    private function validate(SearchCommand $command): bool
    {
        $errors = $this->validator->validate($command);

        if (0 !== \count($errors)) {
            throw new ValidatorException($errors[0]->getPropertyPath().': '.$errors[0]->getMessage());
        }

        return true;
    }
}

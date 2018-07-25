<?php

namespace App\Handler;

use App\Command\SearchCommand;
use App\Model\ArgumentsModel;
use App\Service\VendorsFileProcessor;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SearchHandler
{
    /** @var ValidatorInterface */
    private $validator;
    /** @var VendorsFileProcessor */
    private $processor;

    public function __construct(ValidatorInterface $validator, VendorsFileProcessor $processor) {
        $this->validator = $validator;
        $this->processor = $processor;
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

            $this->processor->process($command->getFilePath(), $arguments);

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

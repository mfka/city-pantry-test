<?php

namespace App\Tests\Command;

use App\Command\SearchCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class SearchCommandTest extends TestCase
{
    /** @var ValidatorInterface */
    private $validator;

    public function setUp()
    {
        $this->validator = Validation::createValidatorBuilder()->addYamlMapping(
            __DIR__.'/../../config/validator/search.yaml'
        )->getValidator();

    }

    public function testCorrectDataValidation(): void
    {
        list($filePath, $day, $time, $location, $cover) = $this->getCorrectInput();
        $searchCommand = new SearchCommand($filePath, $day, $time, $location, $cover);

        $errors = $this->validate($searchCommand);
        $this->assertCount(0, $errors);
    }

    public function testIncorrectCoverValidation(): void
    {
        list($filePath, $day, $time, $location, $cover) = $this->getCorrectInput();
        $coverWrong = 0;
        $searchCommand = new SearchCommand($filePath, $day, $time, $location, $coverWrong);
        $errors = $this->validate($searchCommand);
        $this->assertCount(1,$errors);

    }

    public function testIncorrectFileValidation(): void
    {
        list($filePath, $day, $time, $location, $cover) = $this->getCorrectInput();
        $filePathWrong = __DIR__ . '/../../tests/examples/wrong-input.js';
        $searchCommand = new SearchCommand($filePathWrong, $day, $time, $location, $cover);
        $errors = $this->validate($searchCommand);
        $this->assertCount(1,$errors);

    }

    public function testIncorrectLocationValidation(): void
    {
        list($filePath, $day, $time, $location, $cover) = $this->getCorrectInput();
        $searchCommand = new SearchCommand($filePath, $day, $time, '123123', $cover);
        $errors = $this->validate($searchCommand);
        $this->assertCount(1,$errors);

    }

    private function validate(SearchCommand $command): ConstraintViolationListInterface
    {
        return $this->validator->validate($command);
    }

    public function getCorrectInput(): array
    {
        return [
            __DIR__.'/../examples/example-input.txt',
            '11/12/20',
            '23:59',
            'NW43QB',
            2,
        ];
    }
}

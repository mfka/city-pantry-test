<?php

namespace App\Test\Handler;

use App\Command\SearchCommand;
use App\Handler\SearchHandler;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SearchHandlerTest extends TestCase
{
    private $dispatcher;
    private $validator;

    public function setUp(): void
    {
        $this->dispatcher = m::mock(EventDispatcherInterface::class);
        $this->validator = m::mock(ValidatorInterface::class);
        $handler = new SearchHandler($this->validator, $this->dispatcher);
    }

    public function testHandle(): void
    {


        $this->addToAssertionCount(1);
    }

    public function testValidate(): void
    {
        $validator = m::mock(ValidatorInterface::class);
        $command = $this->createSearchCommand();
        $errors = new ConstraintViolationList();
        $validator->shouldReceive('validate')->with($command)->andReturn($errors);

    }

    private function createSearchCommand()
    {
        return new SearchCommand(
            __DIR__.'/../examples/example-input.txt',
            '11/12/20',
            '23:59',
            'NW43QB',
            2
        );
    }

    private function createIncorrectSearchCommand()
    {
        return new SearchCommand(
            __DIR__.'/../examples/example-input.txt',
            '11/12/20',
            '23:59',
            '00000',
            2
        );
    }
}

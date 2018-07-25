<?php

namespace App\Test\Handler;

use App\Command\SearchCommand;
use App\Handler\SearchHandler;
use App\Service\VendorsFileProcessor;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SearchHandlerTest extends TestCase
{

    public function testHandle(): void
    {
        $processor = m::mock(VendorsFileProcessor::class);
        $processor->shouldReceive('process');
        $validator = m::mock(ValidatorInterface::class);
        $validator->shouldReceive('validate')->andReturn([]);
        $handler = new SearchHandler($validator, $processor);
        $handler->handle($this->createSearchCommand());
        $this->addToAssertionCount(1);
    }

    public function testValidateError(): void
    {
        $processor = m::mock(VendorsFileProcessor::class);
        $validator = m::mock(ValidatorInterface::class);
        $error = new ConstraintViolation('error','message {{template}}', [],'root', 'ErrorTest','value');
        $validator->shouldReceive('validate')->andReturn([$error]);
        $handler = new SearchHandler($validator, $processor);
        $this->expectException(ValidatorException::class);
        $handler->handle($this->createSearchCommand());
    }

    private function createSearchCommand(): SearchCommand
    {
        $command = new SearchCommand(
            __DIR__.'/../examples/example-input.txt',
            '11/12/20',
            '23:59',
            'NW43QB',
            2
        );

        return $command;
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

<?php


namespace App\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

class ConstrainsGreaterThanDate extends Constraint
{
    public $format = 'Y/m/d H:i:s';
    public $message = 'Served time: {{ value }} this time has already passed. Must be greater than {{ actual_time }}';
    public $messageInvalidFormat = 'Served time: {{ value }} has invalid fomrat. Must be like {{ format }}';

    public function getDefaultOption(): string
    {
        return 'format';
    }

    public function getRequiredOptions(): array
    {
        return ['format'];
    }
}
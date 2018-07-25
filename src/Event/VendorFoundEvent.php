<?php

namespace App\Event;

use App\Model\ArgumentsModel;
use App\Model\MealModel;
use App\Model\RestaurantModel;
use Symfony\Component\EventDispatcher\Event;

class VendorFoundEvent extends Event
{
    public const NAME = 'vendor.found';

    /** @var array */
    private $vendor;
    /** @var ArgumentsModel */
    private $arguments;

    public function __construct(array $vendor, ArgumentsModel $arguments)
    {
        $this->vendor = $vendor;
        $this->arguments = $arguments;
    }

    public function getVendor(): array
    {
        return $this->vendor;
    }

    public function getArguments(): ArgumentsModel
    {
        return $this->arguments;
    }
}
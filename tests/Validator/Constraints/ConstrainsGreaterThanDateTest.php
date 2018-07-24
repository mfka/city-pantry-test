<?php

namespace App\Validator\Constraints;

use PHPUnit\Framework\TestCase;

class ConstrainsGreaterThanDateTest extends TestCase
{
    /** @var ConstrainsGreaterThanDate */
    public $constrains;

    public function setUp(){
        $this->constrains = new ConstrainsGreaterThanDate(['format'=> 'Y/m/d H:i:s']);
    }
    public function testDefaultFormat(){
        $this->assertTrue($this->constrains->format === 'Y/m/d H:i:s');
        $this->assertFalse($this->constrains->format === 'H:i');
    }
}

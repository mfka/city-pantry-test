<?php

namespace App\Service;

use App\Event\VendorFoundEvent;
use App\Model\ArgumentsModel;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Validator\Exception\ValidatorException;

class VendorsFileProcessor
{
    /** @var EventDispatcherInterface */
    private $dispatcher;
    /** @var ArgumentsModel */
    private $arguments;

    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function process(string $filePath, ArgumentsModel $arguments): void
    {
        $this->arguments = $arguments;
        $vendor = [];
        $handle = fopen($filePath, 'r');
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                if (!preg_match('/^\s*$/m', $line)) {

                    $row = $this->getRow($line);

                    $vendor[] = $row;
                    continue;
                }
                $this->emitVendor($vendor);
                $vendor = [];

            }
            fclose($handle);
            $this->emitVendor($vendor);
        }
    }

    private function getRow(string $line): array
    {
        $row = explode(';', $line);

        if (\count($row) !== 3) {
            throw new ValidatorException('Incorrect line in file.'.$line);
        }

        return $row;
    }

    private function emitVendor(array $vendor): void
    {
        $this->dispatcher->dispatch(VendorFoundEvent::NAME, new VendorFoundEvent($vendor, $this->arguments));
    }
}

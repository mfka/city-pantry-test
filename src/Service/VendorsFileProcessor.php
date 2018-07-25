<?php

namespace App\Service;

use App\Event\VendorFoundEvent;
use App\Model\ArgumentsModel;
use App\Validator\VendorRowValidator;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class VendorsFileProcessor
{
    /** @var EventDispatcherInterface */
    private $dispatcher;
    /** @var ArgumentsModel */
    private $arguments;
    /** @var VendorRowValidator */
    private $validator;

    public function __construct(EventDispatcherInterface $dispatcher, VendorRowValidator $validator)
    {
        $this->dispatcher = $dispatcher;
        $this->validator = $validator;
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

        $this->validator->validate($row);

        return $row;
    }

    private function emitVendor(array $vendor): void
    {
        $this->dispatcher->dispatch(VendorFoundEvent::NAME, new VendorFoundEvent($vendor, $this->arguments));
    }
}

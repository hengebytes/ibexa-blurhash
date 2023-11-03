<?php

namespace HengeBytes\IbexaBlurhashBundle;

use HengeBytes\IbexaBlurhashBundle\DependencyInjection\HBIbexaBlurhashExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class HBIbexaBlurhashBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }

    public function getContainerExtension(): ?ExtensionInterface
    {
        if (!$this->extension) {
            $this->extension = new HBIbexaBlurhashExtension();
        }

        return $this->extension;
    }
}

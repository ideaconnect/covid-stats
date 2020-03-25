<?php

namespace App\Factory;

use App\Entity\StatsSource;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;

class HandlerFactory
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function createHandler(StatsSource $source)
    {
        $class = 'App\\Handler\\' . ucfirst($source->getCode()) . 'Handler';
        if (!class_exists($class)) {
            throw new RuntimeException("Missing handler `" . $class . "`.");
        }

        $handler = new $class($source, $this->em);

        return $handler;
    }
}

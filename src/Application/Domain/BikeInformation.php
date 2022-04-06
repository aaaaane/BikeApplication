<?php

declare(strict_types=1);

namespace Vanmoof\Application\Domain;

class BikeInformation
{
    public function __construct(private ?string $name = null, private ?int $model = null)
    {
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getModel(): ?int
    {
        return $this->model;
    }
}

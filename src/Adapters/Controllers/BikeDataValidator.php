<?php

declare(strict_types=1);

namespace Vanmoof\Adapters\Controllers;

use Exception;
use Webmozart\Assert\Assert;

class BikeDataValidator implements DataValidator
{
    /**
     * @throws Exception
     */
    public function validateData
    (
        ?string $userId = null,
        ?string $bikeId = null,
        ?string $name = null,
        ?int    $model = null,
    ): void
    {
        if ($userId !== null) {
            Assert::uuid($userId);
        }

        if ($bikeId !== null) {
            Assert::uuid($bikeId);
        }

        if ($name !== null) {
            Assert::string($name);
        }

        if ($model !== null) {
            Assert::integer($model);
        }

    }
}

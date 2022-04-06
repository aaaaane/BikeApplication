<?php

namespace Vanmoof\Adapters\Controllers;

use Exception;

interface DataValidator
{
    /**
     * @throws Exception
     */
    public function validateData(): void;
}

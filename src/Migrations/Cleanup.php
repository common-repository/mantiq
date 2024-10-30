<?php

namespace Mantiq\Migrations;

use Mantiq\Concerns\Singleton;

class Cleanup
{
    use Singleton;

    public function __construct()
    {
        //@TODO
        // 1. Query the active workflows that are scheduled
        // 2. Iterate over them and remove their respective scheduled hook
    }
}

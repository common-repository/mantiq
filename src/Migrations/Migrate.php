<?php

namespace Mantiq\Migrations;

use Mantiq\Concerns\Singleton;
use Mantiq\Migrations\Versions\Version1;
use Mantiq\Plugin;

class Migrate
{
    use Singleton;

    public function __construct()
    {
        $currentVersion = $newVersion = Plugin::getOption('database_version', 0);
        try {
            if ($currentVersion < 1) {
                Version1::invoke();
                $newVersion = 1;
            }


            if ($currentVersion !== $newVersion) {
                Plugin::setOption('database_version', $newVersion);
            }
        } catch (\Exception $exception) {
            //@TODO Handle this
        }
    }
}

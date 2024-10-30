<?php

namespace Mantiq\Tasks\Triggers;

use Mantiq\FormProviders\TotalFormFormProvider;

class RegisterDefaultTriggerForms
{
    public static function invoke()
    {
        TotalFormFormProvider::register();
    }
}

<?php

namespace Mantiq\Tasks\Workflows\Repository;

class GetWorkflow
{
    public static function invoke($uid)
    {
        $workflows = GetWorkflows::invoke(
            [
                'conditions' => ['uid' => $uid],
                'perPage'    => 1,
            ]
        );

        return $workflows->first();
    }

}

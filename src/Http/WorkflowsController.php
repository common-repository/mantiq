<?php

namespace Mantiq\Http;

use Mantiq\Concerns\Singleton;
use Mantiq\Http\Routes\CreateWorkflowRoute;
use Mantiq\Http\Routes\ExecuteWorkflowRoute;
use Mantiq\Http\Routes\GetWorkflowLogRoute;
use Mantiq\Http\Routes\GetWorkflowRoute;
use Mantiq\Http\Routes\GetWorkflowsRoute;
use Mantiq\Http\Routes\TrashWorkflowRoute;
use Mantiq\Http\Routes\UpdateWorkflowRoute;

class WorkflowsController
{
    use Singleton;

    public function __construct()
    {
        add_action('rest_api_init', [$this, 'register']);
    }

    public function register()
    {
        UpdateWorkflowRoute::register();
        TrashWorkflowRoute::register();
        CreateWorkflowRoute::register();
        GetWorkflowLogRoute::register();
        GetWorkflowRoute::register();
        GetWorkflowsRoute::register();
//        ExecuteWorkflowRoute::register();
    }
}

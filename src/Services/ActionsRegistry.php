<?php

namespace Mantiq\Services;

use Mantiq\Actions\VoidAction;
use Mantiq\Concerns\Singleton;
use Mantiq\Models\Action;
use Mantiq\Support\Collection;

class ActionsRegistry
{
    use Singleton;

    /**
     * @var Collection<Action>|Action []
     */
    protected $actions;

    public function __construct()
    {
        $this->actions = Collection::create();
    }

    /**
     * @param $actionId
     * @param  string  $fallback
     *
     * @return Action
     */
    public static function get($actionId, $fallback = VoidAction::class)
    {
        return static::instance()->getAction($actionId) ?: new $fallback();
    }

    public function getAction($id)
    {
        return $this->actions->get($id);
    }

    public function addNewAction(Action $action)
    {
        $this->actions->set($action->getId(), $action);
    }

    public function toArray()
    {
        return $this->actions->toArray();
    }
}

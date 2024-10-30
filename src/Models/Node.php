<?php

namespace Mantiq\Models;

use Mantiq\Support\Collection;

/**
 * @property string uid
 * @property string type
 * @property Collection<Node>|Node[] children
 * @property Collection properties
 */
class Node extends Model
{
    const TRIGGER   = 'trigger';
    const ASSIGN    = 'assign';
    const ACTION    = 'action';
    const CONDITION = 'condition';
    const BRANCH    = 'branch';

    public function fromDatabase($rawAttributes)
    {
        foreach ($rawAttributes['children'] as $childIndex => $child) {
            $rawAttributes['children'][$childIndex] = new Node($child);
        }

        $rawAttributes['children']   = Collection::create($rawAttributes['children']);
        $rawAttributes['properties'] = Collection::create($rawAttributes['properties']);

        return $rawAttributes;
    }

    public function isTrigger()
    {
        return $this->type === self::TRIGGER;
    }

    public function isAssign()
    {
        return $this->type === self::ASSIGN;
    }

    public function isAction()
    {
        return $this->type === self::ACTION;
    }

    public function isCondition()
    {
        return $this->type === self::CONDITION;
    }

    public function isBranch()
    {
        return $this->type === self::BRANCH;
    }
}

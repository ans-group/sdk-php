<?php

namespace UKFast\SDK\PSS\Entities;

use UKFast\SDK\Entities\Entity;

/**
 * @property int $id
 * @property string $name
 * @property string $type
 */
class Author extends Entity
{
    /**
     * @return bool
     */
    public function isSupport()
    {
        return $this->type === 'Support';
    }

    /**
     * @return bool
     */
    public function isClient()
    {
        return $this->type === 'Client';
    }

    /**
     * @return bool
     */
    public function isAutomated()
    {
        return $this->type === 'Auto';
    }
}

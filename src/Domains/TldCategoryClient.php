<?php

namespace UKFast\SDK\Domains;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\Domains\Entities\TldCategory;
use UKFast\SDK\Traits\PageItems;

class TldCategoryClient extends BaseClient
{
    use PageItems;

    protected $basePath = 'registrar/';
    protected $collectionPath = 'v2/tld-categories';

    /**
     * @param object $data
     * @return TldCategory
     */
    public function loadEntity($data)
    {
        return new TldCategory((array) $data);
    }
}

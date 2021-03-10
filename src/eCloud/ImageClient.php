<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;
use UKFast\SDK\eCloud\Entities\Image;

class ImageClient extends Client implements ClientEntityInterface
{
    use PageItems;

    protected $collectionPath = 'v2/images';

    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'name' => 'name',
            'logo_uri' => 'logoUri',
            'description' => 'description',
            'documentation_uri' => 'documentationUri',
            'publisher' => 'publisher',
            'created_at' => 'createdAt',
            'updated_at' => 'updatedAt',
        ];
    }

    public function loadEntity($data)
    {
        return new Image(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }
}

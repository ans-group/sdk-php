<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;
use UKFast\SDK\eCloud\Entities\Image;
use UKFast\SDK\eCloud\Entities\ImageData;
use UKFast\SDK\eCloud\Entities\ImageParameter;

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

    public function getParameters($id)
    {
        $response = $this->get($this->collectionPath . '/' . $id . '/parameters');
        $responseData = $this->decodeJson($response->getBody()->getContents())->data;
        if (empty($responseData)) {
            return [];
        }

        $parameters = [];
        foreach ($responseData as $item) {
            $parameters[] = new ImageParameter($this->apiToFriendly(
                $item,
                [
                    'id' => 'id',
                    'name' => 'name',
                    'key' => 'key',
                    'type' => 'type',
                    'description' => 'description',
                    'required' => 'required',
                    'validation_rule' => 'validationRule',
                ]
            ));
        }

        return $parameters;
    }

    public function getData($id)
    {
        $response = $this->get($this->collectionPath . '/' . $id . '/metadata');
        return new ImageData($this->apiToFriendly(
            $this->decodeJson($response->getBody()->getContents())->data,
            [
                'key' => 'key',
                'value' => 'value',
            ]
        ));
    }
}

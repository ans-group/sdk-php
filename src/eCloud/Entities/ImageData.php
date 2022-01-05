<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $key
 * @property string $value
 */
class ImageData extends Entity
{
    const
        KEY_LICENSE_TYPE = 'ukfast.license.type'
    ;

    /**
     * @return string
     */
    public function getLicenseType()
    {
        foreach ($this->attributes as $imageData) {
            if ($imageData->key == self::KEY_LICENSE_TYPE) {
                return $imageData->value;
            }
        }

        return '';
    }
}

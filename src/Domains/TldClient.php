<?php

namespace UKFast\SDK\Domains;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\Domains\Entities\Tld;
use UKFast\SDK\Traits\PageItems;

class TldClient extends BaseClient
{
    use PageItems;

    protected $basePath = 'registrar/';

    protected $collectionPath = 'v2/tlds';

    /**
     * @param object $data
     * @return Tld
     */
    public function loadEntity($data)
    {
        return new Tld([
            'name' => $data->name,
            'description' => $this->value($data, 'description'),
            'categoryName' => $this->value($data, 'category', 'name'),
            'categoryOrder' => $this->value($data, 'category', 'order'),
            'registrationRealtime' => $this->value($data, 'registration', 'realtime'),
            'registrationRequirements' => $this->value($data, 'registration', 'requirements'),
            'registrationValidation' => $this->value($data, 'registration', 'validation'),
            'registrationIrtp' => $this->value($data, 'registration', 'irtp'),
            'registrationMinTerm' => $this->value($data, 'registration', 'min_term'),
            'renewalAuto' => $this->value($data, 'renewal', 'auto'),
            'renewalMinTerm' => $this->value($data, 'renewal', 'min_term'),
            'renewalMilestone' => $this->value($data, 'renewal', 'milestone'),
            'transferMinTerm' => $this->value($data, 'transfer', 'min_term'),
            'privacyAvailable' => $this->value($data, 'privacy', 'available'),
            'privacyFee' => $this->value($data, 'privacy', 'fee'),
            'createdAt' => $this->value($data, 'created_at'),
            'updatedAt' => $this->value($data, 'updated_at'),
        ]);
    }

    /**
     * A field of the API response, or of one of its sections, or null
     * when it isn't there
     *
     * @param object $data
     * @param string $key
     * @param string|null $field
     * @return mixed
     */
    private function value($data, $key, $field = null)
    {
        if (!isset($data->$key)) {
            return null;
        }

        if (is_null($field)) {
            return $data->$key;
        }

        return isset($data->$key->$field) ? $data->$key->$field : null;
    }
}

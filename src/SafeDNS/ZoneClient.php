<?php

namespace UKFast\SDK\SafeDNS;

use UKFast\SDK\Client;
use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Exception\UKFastException;
use UKFast\SDK\Page;
use UKFast\SDK\SafeDNS\Entities\Zone;

class ZoneClient extends Client implements ClientEntityInterface
{
    protected $basePath = 'safedns/';

    /**
     * Gets a paginated response of all Zones
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v1/zones', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->loadEntity($item);
        });

        return $page;
    }

    /**
     * Gets an individual Zone
     *
     * @param string $name
     * @return Zone
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getByName($name)
    {
        $response = $this->request("GET", "v1/zones/$name");
        $body = $this->decodeJson($response->getBody()->getContents());

        return $this->loadEntity($body->data);
    }

    /**
     * Create a new zone
     *
     * @param Zone $zone
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create(Zone $zone)
    {
        $data = [
            'name' => $zone->name,
        ];

        if (!empty($zone->description)) {
            $data['description'] = $zone->description;
        }

        $response = $this->post("v1/zones", json_encode($data), [
            'Content-Type' => 'application/json'
        ]);

        if ($response->getStatusCode() != 201) {
            throw new UKFastException('unexpected response code: ' . $response->getStatusCode());
        }

        return $zone;
    }

    /**
     * Update an existing zone
     *
     * @param Zone $zone
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update(Zone $zone)
    {
        $data = [
            'description' => $zone->description,
        ];

        $response = $this->patch("v1/zones/".$zone->name."", json_encode($data), [
            'Content-Type' => 'application/json'
        ]);

        return $response->getStatusCode() == 200;
    }

    /**
     * Delete a zone by name
     *
     * @param $name
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteByName($name)
    {
        $response = $this->delete("v1/zones/$name");

        return $response->getStatusCode() == 204;
    }

    /**
     * Load entity from API data
     * @param $data
     * @return mixed
     */
    public function loadEntity($data)
    {
        return new Zone([
            'name'        => $data->name,
            'description' => $data->description,
        ]);
    }
}

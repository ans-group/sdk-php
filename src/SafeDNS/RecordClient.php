<?php

namespace UKFast\SDK\SafeDNS;

use UKFast\SDK\Client;
use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Page;
use UKFast\SDK\SafeDNS\Entities\Record;
use UKFast\SDK\SelfResponse;

class RecordClient extends Client implements ClientEntityInterface
{
    protected $basePath = 'safedns/';

    const RECORD_MAP = [
        'updated_at' => 'updatedAt'
    ];

    /**
     * Get records by zone name
     * @param $zoneName
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return int|Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getByZoneName($zoneName, $page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v1/zones/'.$zoneName.'/records', $page, $perPage, $filters);
        $page->serializeWith(function ($item) use ($zoneName) {
            $item->zone = $zoneName;
            return $this->loadEntity($item);
        });

        return $page;
    }

    /**
     * Gets a specific zone record by ID
     *
     * @param $zoneName
     * @param string $id
     * @return Record
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getZoneRecordById($zoneName, $id)
    {
        $response = $this->request("GET", "v1/zones/$zoneName/records/$id");
        $body = $this->decodeJson($response->getBody()->getContents());

        // Zone isn't currently returned by the API
        $body->data->zone = $zoneName;

        return $this->loadEntity($body->data);
    }

    /**
     * Create a new record
     *
     * @param Record $record
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create(Record $record)
    {
        $data         = $this->friendlyToApi($record, static::RECORD_MAP);
        $data['type'] = strtoupper($data['type']);

        $response = $this->post('v1/zones/' . $record->zone . '/records', json_encode($data));
        $body     = $this->decodeJson($response->getBody()->getContents());
        $zoneName = $record->zone;

        return (new SelfResponse($body))
            ->setClient($this)
            ->serializeWith(function ($body) use ($zoneName) {
                $record       = new Record($body->data);
                $record->zone = $zoneName;

                return $record;
            });
    }

    /**
     * Update an existing record
     *
     * @param Record $record
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update(Record $record)
    {
        $data = [
            'name' => $record->name,
            'content' => $record->content,
        ];

        $response = $this->patch("v1/zones/".$record->zone."/records/".$record->id."", json_encode($data), [
            'Content-Type' => 'application/json'
        ]);

        return $response->getStatusCode() == 200;
    }

    /**
     * Delete a record
     *
     * @param Record $record
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function destroy(Record $record)
    {
        $response = $this->delete("v1/zones/".$record->zone."/records/".$record->id."");

        return $response->getStatusCode() == 204;
    }

    /**
     * Load entity from API data
     * @param $data
     * @return Record
     */
    public function loadEntity($data)
    {
        return new Record([
            'id'      => $data->id,
            'zone'    => $data->zone,
            'name'    => $data->name,
            'type'    => $data->type,
            'content' => $data->content,
            'ttl'     => $data->ttl,
        ]);
    }
}

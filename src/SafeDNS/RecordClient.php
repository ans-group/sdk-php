<?php

namespace UKFast\SDK\SafeDNS;

use UKFast\SDK\Client;
use UKFast\SDK\Page;
use UKFast\SDK\SafeDNS\Entities\Record;

class RecordClient extends Client
{
    protected $basePath = 'safedns/';


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
            return new Record($item);
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

        // zone isnt currently returned by the api
        $body->data->zone = $zoneName;

        return new Record($body->data);
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
        $data = [
            'name' => $record->name,
            'type' => strtoupper($record->type),
            'content' => $record->content,
        ];

        $response = $this->post("v1/zones/".$record->zone."/records", json_encode($data), [
            'Content-Type' => 'application/json'
        ]);

        if ($response->getStatusCode() != 201) {
            throw new UKFastException('unexpected response code: ' . $response->getStatusCode());
        }

        $body = $this->decodeJson($response->getBody()->getContents());

        $record->id = $body->data->id;

        return $record;
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
}

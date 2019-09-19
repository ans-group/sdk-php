<?php

namespace UKFast\SDK\SafeDNS;

use UKFast\SDK\Client;
use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Page;
use UKFast\SDK\SafeDNS\Entities\Note;

class NoteClient extends Client implements ClientEntityInterface
{
    /**
     * Get records by zone name
     *
     * @param string $zoneName
     * @param int    $page
     * @param int    $perPage
     * @param array $filters
     * @return Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getByZoneName($zoneName, $page = 1, $perPage = 20, $filters = [])
    {
        $page = $this->paginatedRequest('v1/zones/' . rawurlencode($zoneName) . '/notes', $page, $perPage, $filters);
        $page->serializeWith(function ($item) use ($zoneName) {
            $item->zone = $zoneName;

            return new Note($item);
        });

        return $page;
    }

    /**
     * Gets a specific zone note by ID
     *
     * @param string $zoneName
     * @param string $id
     * @return Note
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getByZoneNameAndId($zoneName, $id)
    {
        $response = $this->request("GET", 'v1/zones/' . rawurlencode($zoneName) . '/records/' . rawurlencode($id));
        $body     = $this->decodeJson($response->getBody()->getContents());

        // The zone isn't currently returned by the API
        $body->data->zone = $zoneName;

        return $this->loadEntity($body->data);
    }

    /**
     * Create a note
     *
     * @param Note $note
     * @return Note
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create(Note $note)
    {
        $response = $this->post(
            'v1/zones/' . rawurlencode($note->zone) . "/notes",
            json_encode([
                'user_id' => $note->contactId,
                'note'    => $note->content,
                'ip'      => $note->ipAddress,
            ]),
            ['Content-Type' => 'application/json']
        );

        $body     = $this->decodeJson($response->getBody()->getContents());
        $note->id = $body->data->id;

        return $note;
    }

    /**
     * Load entity from API data
     *
     * @param  $data
     * @return Note
     */
    public function loadEntity($data)
    {
        $createdAt = \DateTime::createFromFormat(DATE_ISO8601, $data->created_at);
        if ($createdAt === false) {
            $createdAt = null;
        }

        return new Note([
            'id'         => $data->id,
            'zone'       => $data->zone,
            'contactId'  => $data->contact_id,
            'content'    => $data->note,
            'ipAddress'  => $data->ip,
            'createdAt' => $createdAt,
        ]);
    }
}

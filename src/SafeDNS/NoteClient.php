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
     * @param string $zoneName
     * @param int    $page
     * @param int    $perPage
     * @param array $filters
     * @return Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getByZoneName($zoneName, $page = 1, $perPage = 20, $filters = [])
    {
        $page = $this->paginatedRequest('v1/zones/'.$zoneName.'/notes', $page, $perPage, $filters);
        $page->serializeWith(function ($item) use ($zoneName) {
            $item->zone = $zoneName;

            return new Note($item);
        });

        return $page;
    }

    /**
     * Load entity from API data
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

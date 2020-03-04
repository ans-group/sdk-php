<?php

namespace UKFast\SDK\DRaaS;

use UKFast\SDK\DRaaS\Entities\BackupService;
use UKFast\SDK\DRaaS\Entities\BackupResources;
use UKFast\SDK\DRaaS\Entities\Solution;
use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Page;

class SolutionClient extends Client implements ClientEntityInterface
{
    const MAP = [
        'id' => 'id',
        'name' => 'name',
        'iops_tier_id' => 'iopsTierId',
    ];

    const BACKUP_SERVICE_MAP = [
        'service' => 'service',
        'account_name' => 'accountName'
    ];

    /**
     * Gets a paginated response of Solutions
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest("v1/solutions", $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->loadEntity($item);
        });

        return $page;
    }

    /**
     * Gets an individual Solution
     *
     * @param int $id
     * @return Solution
     */
    public function getById($id)
    {
        $response = $this->get("v1/solutions/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->loadEntity($body->data);
    }

    /**
     * Returns information relating to the backup service linked to the solution
     * @param $id
     * @return BackupService
     */
    public function getBackupService($id)
    {
        $response = $this->get("v1/solutions/$id/backup-service");
        $body = $this->decodeJson($response->getBody()->getContents());
        return new BackupService($this->apiToFriendly($body, static::BACKUP_SERVICE_MAP));
    }
  
    /**
     * Get backup resources for the solution
     * @param integer $id Solution ID
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     */
    public function getBackupResources($id, $page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest("v1/solutions/$id/backup-resources", $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new BackupResources($this->apiToFriendly($item, BackupResourcesClient::MAP));
        });

        return $page;
    }
  
    /**
     * @param Solution $solution
     * @return bool
     */
    public function update(Solution $solution)
    {
        $data = [
            'name' => $solution->name,
            'iops_tier_id' => $solution->iopsTierId,
        ];

        $response = $this->patch("v1/solutions/" . $solution->id, json_encode($data), [
            'Content-Type' => 'application/json'
        ]);

        return $response->getStatusCode() == 200;
    }

    /**
     * Load an instance of Datastore from API data
     * @param $data
     * @return Solution
     */
    public function loadEntity($data)
    {
        return new Solution($this->apiToFriendly($data, static::MAP));
    }
}

<?php

namespace UKFast\SDK\DRaaS;

use UKFast\SDK\DRaaS\Entities\ComputeResources;
use UKFast\SDK\DRaaS\Entities\BackupService;
use UKFast\SDK\DRaaS\Entities\BackupResources;
use UKFast\SDK\DRaaS\Entities\Solution;
use UKFast\SDK\DRaaS\Entities\NetworkAppliance;
use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Page;

class SolutionClient extends Client implements ClientEntityInterface
{
    const MAP = [
        'id' => 'id',
        'name' => 'name',
        'iops_tier_id' => 'iopsTierId',
        'billing_type_id' => 'billingTypeId',
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
     * Get network appliances for the solution
     * @param integer $id Solution ID
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     */
    public function getNetworkAppliancesPage($id, $page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest("v1/solutions/$id/network-appliances", $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new NetworkAppliance($this->apiToFriendly($item, NetworkApplianceClient::MAP));
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
     * Return a paginated response of compute resources associated with the solution
     * @param $id
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return int|Page
     *
     * @deprecated please use ComputeResourcesClient::getPage()
     */
    public function getComputeResourcesPage($id, $page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest("v1/solutions/$id/compute-resources", $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new ComputeResources($this->apiToFriendly($item, ComputeResourcesClient::MAP));
        });

        return $page;
    }

    /**
     * Reset the credentials for the solution's backup service.
     * @param $id string The solution ID
     * @param $newPassword
     * @return bool
     */
    public function resetBackupServiceCredentials($id, $newPassword)
    {
        $response = $this->post(
            "v1/solutions/$id/backup-service/reset-credentials",
            json_encode(['password' => $newPassword])
        );

        return $response->getStatusCode() == 202;
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

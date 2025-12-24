<?php

namespace UKFast\SDK\eCloud;

use GuzzleHttp\Exception\GuzzleException;
use UKFast\SDK\eCloud\Entities\Volume;
use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Exception\UKFastException;
use UKFast\SDK\Traits\PageItems;
use UKFast\SDK\eCloud\Entities\Instance;

/**
 * @method Instance getById($id)
 */
class InstanceClient extends Client implements ClientEntityInterface
{
    /** @use PageItems<Instance> */
    use PageItems;

    protected $collectionPath = 'v2/instances';

    public function getEntityMap()
    {
        return Instance::$entityMap;
    }

    public function loadEntity($data)
    {
        return new Instance(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }

    /**
     * Get array of instance credentials
     * @param $id
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getCredentials($id)
    {
        $currentPage = 1;
        $perPage = 15;

        $page = $this->paginatedRequest(
            $this->collectionPath . '/' . $id . '/credentials',
            $currentPage,
            $perPage
        );

        if ($page->totalItems() == 0) {
            return [];
        }

        $credentialsClient = new CredentialsClient;
        $page->serializeWith(function ($item) use ($credentialsClient) {
            return $credentialsClient->loadEntity($item);
        });

        $items = $page->getItems();
        if ($page->totalPages() == 1) {
            return $items;
        }

        // get any remaining pages
        while ($page->pageNumber() < $page->totalPages()) {
            $page = $this->paginatedRequest(
                $this->collectionPath . '/' . $id . '/credentials',
                $currentPage++,
                $perPage
            );

            $page->serializeWith(function ($item) use ($credentialsClient) {
                return $credentialsClient->loadEntity($item);
            });

            $items = array_merge(
                $items,
                $page->getItems()
            );
        }

        return $items;
    }

    /**
     * Get array of instance volumes
     * @param string $id
     * @param array<string, mixed> $filters
     * @return array<int, Volume>
     * @throws GuzzleException
     */
    public function getVolumes($id, $filters = [])
    {
        return $this->getChildResources($id, 'volumes', function ($data) {
            return (new VolumeClient())->loadEntity($data);
        }, $filters);
    }

    /**
     * Get array of instance nics
     * @param $id
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getNics($id)
    {
        $page = $this->paginatedRequest(
            $this->collectionPath . '/' . $id . '/nics',
            $currentPage = 1,
            $perPage = 15
        );

        if ($page->totalItems() == 0) {
            return [];
        }

        $nicClient = new NicClient;
        $page->serializeWith(function ($item) use ($nicClient) {
            return $nicClient->loadEntity($item);
        });

        $items = $page->getItems();
        if ($page->totalPages() == 1) {
            return $items;
        }

        // get any remaining pages
        while ($page->pageNumber() < $page->totalPages()) {
            $page = $this->paginatedRequest(
                $this->collectionPath . '/' . $id . '/nics',
                $currentPage++,
                $perPage
            );

            $page->serializeWith(function ($item) use ($nicClient) {
                return $nicClient->loadEntity($item);
            });

            $items = array_merge(
                $items,
                $page->getItems()
            );
        }

        return $items;
    }

    public function getFloatingIps($instanceId)
    {
        return $this->floatingIps()->getAllByInstanceId($instanceId);
    }

    public function getByVolumeId($volumeId)
    {
        $page = $this->paginatedRequest('v2/volumes/'.$volumeId.'/instances', 1, 100);
        if ($page->totalItems() == 0) {
            return [];
        }

        $page->serializeWith(function ($item) {
            return $this->loadEntity($item);
        });

        $collection = $page->getItems();
        if ($page->totalPages() == 1) {
            return $collection;
        }

        // get any remaining pages
        while ($page->pageNumber() < $page->totalPages()) {
            $page = $this->getPage($page->pageNumber() + 1, 100);
            $collection = array_merge(
                $collection,
                $page->getItems()
            );
        }

        return $collection;
    }

    public function getConsoleSession($id)
    {
        $response = $this->post($this->collectionPath . '/' . $id . '/console-session');

        if ($response->getStatusCode() != 200) {
            throw new UKFastException('unexpected response code: ' . $response->getStatusCode());
        }

        return $this->decodeJson($response->getBody()->getContents())->data;
    }

    public function getConsoleScreenshot($id)
    {
        $response = $this->get($this->collectionPath . '/' . $id . '/console-screenshot');

        if ($response->getStatusCode() != 200) {
            throw new UKFastException('unexpected response code: ' . $response->getStatusCode());
        }

        $screenshot = (object) [
            'name' => null,
            'type' => null,
            'data' => $response->getBody()->getContents(),
        ];

        if (is_array($response->getHeader('Content-Disposition'))) {
            $screenshot->name = explode('filename=', $response->getHeader('Content-Disposition')[0])[1];
        }

        if (is_array($response->getHeader('Content-Type'))) {
            $screenshot->type = explode('/', $response->getHeader('Content-Type')[0])[1];
        }

        return $screenshot;
    }

    public function encrypt($id)
    {
        $response = $this->put($this->collectionPath . '/' . $id . '/encrypt');

        if ($response->getStatusCode() != 202) {
            throw new UKFastException('unexpected response code: ' . $response->getStatusCode());
        }

        return $this->decodeJson($response->getBody()->getContents())->data;
    }

    public function decrypt($id)
    {
        $response = $this->put($this->collectionPath . '/' . $id . '/decrypt');

        if ($response->getStatusCode() != 202) {
            throw new UKFastException('unexpected response code: ' . $response->getStatusCode());
        }

        return $this->decodeJson($response->getBody()->getContents())->data;
    }
}

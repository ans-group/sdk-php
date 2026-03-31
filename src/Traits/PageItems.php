<?php

namespace UKFast\SDK\Traits;

use UKFast\SDK\Entity;
use UKFast\SDK\Page;
use UKFast\SDK\SelfResponse;

/**
 * @template T of Entity
 */
trait PageItems
{
    /**
     * Return array of api properties to map to the entity
     * @return array
     */
    public function getEntityMap()
    {
        return [];
    }

    /**
     * Return an entity model
     * @param $data
     * @return T
     */
    abstract public function loadEntity($data);

    /**
     * Get a paginated response from a collection
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page<T>
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $entityMap = $this->getEntityMap();
        if (!empty($entityMap)) {
            $filters = $this->friendlyToApi($filters, $entityMap);
        }

        $page = $this->paginatedRequest($this->collectionPath, $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->loadEntity($item);
        });

        return $page;
    }

    /**
     * Get an array of all items from all pages
     *
     * @param array $filters
     * @return array<int, T>
     */
    public function getAll($filters = [])
    {
        // get first page
        $page = $this->getPage(1, $perPage = 100, $filters);
        if ($page->totalItems() == 0) {
            return [];
        }

        $items = $page->getItems();
        if ($page->totalPages() == 1) {
            return $items;
        }

        // get any remaining pages
        while ($page->pageNumber() < $page->totalPages()) {
            $page = $this->getPage($page->pageNumber() + 1, $perPage, $filters);
            $items = array_merge(
                $items,
                $page->getItems()
            );
        }

        return $items;
    }

    /**
     * Get a single item from the collection
     * @param $id
     * @return T
     */
    public function getById($id)
    {
        $response = $this->get($this->collectionPath . '/' . $id);
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->loadEntity($body->data);
    }

    /**
     * Delete a single item from the collection
     * @param string $id
     * @param null|array<string, mixed> $body
     * @return bool
     */
    public function deleteById($id, $body = null)
    {
        $response = $this->delete($this->collectionPath . '/' . $id, $body);
        return $response->getStatusCode() == 204;
    }

    /**
     * Create a new item for the collection
     * @param T $entity
     * @return SelfResponse
     */
    public function createEntity($entity)
    {
        $response = $this->post(
            $this->collectionPath,
            json_encode($this->friendlyToApi($entity, $this->getEntityMap()))
        );
        $responseBody = $this->decodeJson($response->getBody()->getContents());

        return (new SelfResponse($responseBody))
            ->setClient($this)
            ->serializeWith(function ($responseBody) {
                return $this->loadEntity($responseBody->data);
            });
    }

    /**
     * Update an existing item in the collection
     * @param T $entity
     * @return SelfResponse
     */
    public function updateEntity($entity)
    {
        $response = $this->patch(
            $this->collectionPath . '/' . $entity->id,
            json_encode($this->friendlyToApi($entity->getDirty(), $this->getEntityMap()))
        );

        $responseBody = $this->decodeJson($response->getBody()->getContents());

        return (new SelfResponse($responseBody))
            ->setClient($this)
            ->serializeWith(function ($responseBody) {
                return $this->loadEntity($responseBody->data);
            });
    }

    /**
     * Get child resources for a resource e.g GET resource/:id/$resourceName
     * @param $id string ID of the resource to get child resources for
     * @param $resourceName string name of the associated resource as specified in the route path
     * @param $serializer \callback serializer to use for the child resource
     * @param $filters
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getChildResources($id, $resourceName, $serializer, $filters = [])
    {
        $pageNumber = 0;
        $items = [];
        do {
            $pageNumber++;
            $page = $this->paginatedRequest(
                $this->collectionPath . '/' . $id . '/' . $resourceName,
                $pageNumber,
                15,
                $filters
            );

            $page->serializeWith($serializer);
            $items = array_merge(
                $items,
                $page->getItems()
            );
        } while ($pageNumber < $page->totalPages());

        return $items;
    }
}

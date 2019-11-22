<?php

namespace UKFast\SDK\Loadbalancers;

use UKFast\SDK\Client;
use UKFast\SDK\Loadbalancers\Entities\Frontend;

class FrontendClient extends Client
{
    /**
     * Gets a paginated response of all ACLs
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return \UKFast\SDK\Page
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v2/frontends', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->serializeFrontend($item);
        });

        return $page;
    }

    /**
     * Gets an individual request
     *
     * @param int $id
     * @return \UKFast\SDK\PSS\Entities\Request
     */
    public function getById($id)
    {
        $response = $this->request("GET", "v2/frontends/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->serializeFrontend($body->data);
    }

    protected function serializeFrontend($raw)
    {
        return new Frontend([
            'id' => $raw->id,
            'name' => $raw->name,
            'vipsId' => $raw->vips_id,
            'port' => $raw->port,
            'hstsEnabled' => $raw->hsts_enabled,
            'mode' => $raw->mode,
            'hstsMaxAge' => $raw->hsts_maxage,
            'close' => $raw->close,
            'redirectHttps' => $raw->redirect_https,
            'defaultBackendId' => $raw->default_backend_id,
        ]);
    }
}

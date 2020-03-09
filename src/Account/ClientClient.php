<?php

namespace UKFast\SDK\Account;

use UKFast\SDK\Client as BaseClient;

class ClientClient extends BaseClient
{
    protected $basePath = 'clients/';

    /**
     * @param $id
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function destroy($id)
    {
        $response = $this->delete('v1/clients/' . $id);
        return $response->getStatusCode() == 204;
    }
}

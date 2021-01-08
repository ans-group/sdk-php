<?php

namespace UKFast\SDK\ThreatMonitoring;

use Exception;
use http\QueryString;
use UKFast\SDK\ThreatMonitoring\Entities\Groups;

class UserClient extends Client
{
    /**
     * Check if a user account exists
     * @return bool
     * @throws Exception
     */
    public function check()
    {
        try {
            $response = $this->get('v1/accounts/check');
            $body = $this->decodeJson($response->getBody()->getContents());

            return $body->data->status == 'Active';
        } catch (Exception $e) {
            if ($e->getMessage() == 'Account not found') {
                return false;
            }

            throw new Exception($e->getMessage());
        }
    }
    
    /**
     * Get the groups that are assigned to a user
     * @param array $filters
     * @return Groups
     */
    public function getGroups()
    {
        $response = $this->get('v1/accounts/groups');
        $body = $this->decodeJson($response->getBody()->getContents());
        return new Groups($body->data);
    }
}

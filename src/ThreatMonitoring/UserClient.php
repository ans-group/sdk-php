<?php

namespace UKFast\SDK\ThreatMonitoring;

use Exception;
use UKFast\Admin\ThreatMonitoring\Entities\User;
use UKFast\SDK\ThreatMonitoring\Entities\Groups;

class UserClient extends Client
{
    const MAP = [
        'is_trial' => 'isTrial',
        'has_free_target' => 'hasFreeTarget',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt'
    ];
    
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
     * Gets paginated response for all the users
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return \UKFast\SDK\Page
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v1/accounts', $page, $perPage, $filters);
    
        $page->serializeWith(function ($item) {
            return $this->serializeResponse($item);
        });
    
        return $page;
    }

    /**
     * Get the groups that are assigned to a user
     * @param $id
     * @return Groups
     */
    public function getGroups()
    {
        $response = $this->get('v1/accounts/groups');
        $body = $this->decodeJson($response->getBody()->getContents());
        return new Groups($body->data);
    }
    
    /**
     * Get the config data for the current user that is making the request
     * @return mixed
     */
    public function getConfig()
    {
        $response = $this->get('v1/configs/user');
        $body = $this->decodeJson($response->getBody()->getContents());
    
        return (new ConfigClient)->serializeResponse($body->data);
    }
    
    /**
     * Serialize the user response data
     * @param $data
     * @return User
     */
    public function serializeResponse($data)
    {
        return new User($this->apiToFriendly($data, static::MAP));
    }
}

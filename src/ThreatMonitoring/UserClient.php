<?php
/**
 * @author: John Birch-Evans <john.birch-evans@ukfast.co.uk>
 * @copyright: 2020 UKFast.net Ltd
 */

namespace UKFast\SDK\ThreatMonitoring;

use Exception;

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
}

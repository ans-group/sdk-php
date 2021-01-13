<?php
/**
 * @author: John Birch-Evans <john.birch-evans@ukfast.co.uk>
 * @copyright: 2021 UKFast.net Ltd
 */

namespace UKFast\SDK\ThreatMonitoring\Reporting;

use UKFast\SDK\Page;
use UKFast\SDK\ThreatMonitoring\Client;
use UKFast\SDK\ThreatMonitoring\Entities\ElevatedPrivileges;
use UKFast\SDK\ThreatMonitoring\Entities\LoginRecord;

class LoginHistoryClient extends Client
{
    const LOGIN_RECORD_MAP = [
        'full_log' => 'fullLog',
        'source_user' => 'sourceUser',
        'target_user' => 'targetUser'
    ];
    
    const ELEVATED_PRIVILEGES_MAP = [
        'source_user' => 'sourceUser'
    ];
    
    /**
     * Returns a timeline of successful logins
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     */
    public function timeline($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v1/reports/logged-in-users/timeline', $page, $perPage, $filters);
    
        $page->serializeWith(function ($item) {
            return $this->serializeLoginTimeline($item);
        });
    
        return $page;
    }
    
    /**
     * Returns a list of when the user has elevated privileges from sudo to root
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     */
    public function elevatedPrivileges($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v1/reports/logged-in-users/elevated-privileges', $page, $perPage, $filters);
    
        $page->serializeWith(function ($item) {
            return $this->serializeElevatedPrivileges($item);
        });
    
        return $page;
    }
    
    public function serializeLoginTimeline($data)
    {
        return new LoginRecord($this->apiToFriendly($data, self::LOGIN_RECORD_MAP));
    }
    
    public function serializeElevatedPrivileges($data)
    {
        return new ElevatedPrivileges($this->apiToFriendly($data, self::ELEVATED_PRIVILEGES_MAP));
    }
}

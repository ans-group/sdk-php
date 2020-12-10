<?php

namespace UKFast\SDK\ThreatMonitoring;

use UKFast\SDK\ThreatMonitoring\Entities\Config;

class ConfigClient extends Client
{
    const FIM_DIRECTORIES_MAP = [
        'check_all' => 'checkAll',
        'check_attrs' => 'checkAttrs',
        'check_group' => 'checkGroup',
        'check_inode' => 'checkInode',
        'check_md5sum' => 'checkMd5sum',
        'check_mtime' => 'checkMtime',
        'check_owner' => 'checkOwner',
        'check_perm' => 'checkPerm',
        'check_sha1sum' => 'checkSha1sum',
        'check_sha256sum' => 'checkSha256sum',
        'check_size' => 'checkSize',
        'check_sum' => 'checkSum',
        'follow_symbolic_link' => 'followSymbolicLink',
        'recursion_level' => 'recursionLevel',
        'report_changes' => 'reportChanges'
    ];

    const LOG_MAP = [
        'log_format' => 'logFormat'
    ];

    /**
     * Get the config data by the group name
     * @param $groupName
     * @return Config
     */
    public function getByGroupName($groupName)
    {
        $response = $this->get('v1/configs/groups/' . $groupName);
        $body = $this->decodeJson($response->getBody()->getContents());

        return $this->serializeResponse($body->data);
    }

    /**
     * Get the config data by the agent id
     * @param $agentId
     * @return Config
     */
    public function getByAgentId($agentId)
    {
        $response = $this->get('v1/configs/agents/' . $agentId);
        $body = $this->decodeJson($response->getBody()->getContents());

        return $this->serializeResponse($body->data);
    }

    /**
     * Serialize the response data
     * @param $data
     * @return Config
     */
    public function serializeResponse($data)
    {
        $directories = [];
        foreach ($data->fim->directories as $directory) {
            $directories[] = $this->apiToFriendly($directory, self::FIM_DIRECTORIES_MAP);
        }

        $logs = [];
        foreach ($data->logs as $log) {
            $logs[] = $this->apiToFriendly($log, self::LOG_MAP);
        }

        $data->fim->directories = $directories;
        $data->logs = $logs;

        return new Config($data);
    }
}

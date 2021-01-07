<?php

namespace UKFast\SDK\ThreatMonitoring;

use UKFast\SDK\ThreatMonitoring\Entities\Config;
use UKFast\SDK\ThreatMonitoring\Entities\Config\Directory;
use UKFast\SDK\ThreatMonitoring\Entities\Config\FimDirectory;
use UKFast\SDK\ThreatMonitoring\Entities\Config\IgnoredDirectory;
use UKFast\SDK\ThreatMonitoring\Entities\Config\Log;
use UKFast\SDK\ThreatMonitoring\Entities\Config\Logs;

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
    
    const IGNORED_DIRECTORIES_MAP = [
        'is_regex' => 'isRegex',
    ];
    
    const LOG_MAP = [
        'log_format' => 'logFormat'
    ];
    
    /**
     * Get the config data by the group name
     * @param $groupName
     * @param array $filters
     * @return Config
     */
    public function getByGroupName($groupName, $filters = [])
    {
        $queryParams = '';
    
        if (count($filters) > 0) {
            $queryParams = '?' . http_build_query($filters);
        }
        
        $response = $this->get('v1/configs/groups/' . $groupName  . $queryParams);
        $body = $this->decodeJson($response->getBody()->getContents());
        
        return $this->serializeResponse($body->data);
    }
    
    /**
     * Get the config data by the agent id
     * @param $agentId
     * @param array $filters
     * @return Config
     */
    public function getByAgentId($agentId, $filters = [])
    {
        $queryParams = '';
    
        if (count($filters) > 0) {
            $queryParams = '?' . http_build_query($filters);
        }
        
        $response = $this->get('v1/configs/agents/' . $agentId  . $queryParams);
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
            $directory = new Directory($this->apiToFriendly($directory, self::FIM_DIRECTORIES_MAP));
            $directories[] = $directory;
        }
        $data->fim->directories = $directories;
        
        $ignoredDirectories = [];
        foreach ($data->fim->ignores as $ignoredDirectory) {
            $ignoredDirectory = new IgnoredDirectory(
                $this->apiToFriendly($ignoredDirectory, self::IGNORED_DIRECTORIES_MAP)
            );
            $ignoredDirectories[] = $ignoredDirectory;
        }
        $data->fim->ignores = $ignoredDirectories;
        
        $logs = [];
        foreach ($data->logs as $log) {
            $log = new Log($this->apiToFriendly($log, self::LOG_MAP));
            $logs[] = $log;
        }
        
        $data->fim = new FimDirectory($data->fim);
        $data->logs = new Logs($logs);
        
        $config = new Config($data);
        $config->syncOriginalAttributes();
        
        return $config;
    }
}

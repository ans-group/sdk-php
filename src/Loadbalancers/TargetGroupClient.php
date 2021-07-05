<?php

namespace UKFast\SDK\Loadbalancers;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Loadbalancers\Entities\TargetGroup;
use UKFast\SDK\Traits\PageItems;

class TargetGroupClient extends BaseClient implements ClientEntityInterface
{
    use PageItems;

    protected $collectionPath = 'v2/target-groups';

    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'name' => 'name',
            'cluster_id' => 'clusterId',
            'cookie_opts' => 'cookieOpts',
            'timeouts_connect' => 'timeoutsConnect',
            'timeouts_server' => 'timeoutsServer',
            'monitor_url' => 'monitorUrl',
            'monitor_method' => 'monitorMethod',
            'monitor_host' => 'monitorHost',
            'monitor_http_version' => 'monitorHttpVersion',
            'monitor_expect' => 'monitorExpect',
            'monitor_tcp_monitoring' => 'monitorTcpMonitoring',
            'custom_options' => 'customOptions',
            'check_port' => 'checkPort',
            'send_proxy' => 'sendProxy',
            'send_proxy_v2' => 'sendProxyV2',
            'ssl_verify' => 'sslVerify',
            'created_at' => 'createdAt',
            'updated_at' => 'updatedAt',
        ];
    }

    public function loadEntity($data)
    {
        return new TargetGroup($this->apiToFriendly($data, $this->getEntityMap()));
    }
}

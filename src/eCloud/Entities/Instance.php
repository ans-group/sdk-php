<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property string $vpcId
 * @property string $availabilityZoneId
 * @property string $imageId
 * @property string $platform
 * @property integer $vcpuCores
 * @property integer $vcpuSockets
 * @property integer $vcpuCoresPerSocket
 * @property integer $ramCapacity
 * @property integer $volumeCapacity
 * @property boolean $locked
 * @property string $status
 * @property boolean $online
 * @property boolean $agentRunning
 * @property boolean $backupEnabled
 * @property boolean $backupVmEnabled
 * @property boolean $backupAgentEnabled
 * @property string $backupGatewayId
 * @property boolean $isEncrypted
 * @property string $hostGroupId
 * @property string $volumeGroupId
 * @property boolean $monitoringEnabled
 * @property string $monitoringGatewayId
 * @property string $createdAt
 * @property string $updatedAt
 */
class Instance extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];

    public static $entityMap = [
        'id' => 'id',
        'name' => 'name',
        'vpc_id' => 'vpcId',
        'availability_zone_id' => 'availabilityZoneId',
        'image_id' => 'imageId',
        'platform' => 'platform',
        'vcpu_cores' => 'vcpuCores',
        'vcpu_sockets' => 'vcpuSockets',
        'vcpu_cores_per_socket' => 'vcpuCoresPerSocket',
        'ram_capacity' => 'ramCapacity',
        'volume_capacity' => 'volumeCapacity',
        'locked' => 'locked',
        'status' => 'status',
        'online' => 'online',
        'agent_running' => 'agentRunning',
        'backup_enabled' => 'backupEnabled',
        'backup_vm_enabled' => 'backupVmEnabled',
        'backup_agent_enabled' => 'backupAgentEnabled',
        'backup_gateway_id' => 'backupGatewayId',
        'is_encrypted' => 'isEncrypted',
        'host_group_id' => 'hostGroupId',
        'volume_group_id' => 'volumeGroupId',
        'monitoring_enabled' => 'monitoringEnabled',
        'monitoring_gateway_id' => 'monitoringGatewayId',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',
    ];
}

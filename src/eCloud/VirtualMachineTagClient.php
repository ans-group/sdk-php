<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\eCloud\Entities\VirtualMachineTag;

class VirtualMachineTagClient extends Client
{
    const VM_TAG_MAP = [];

    public function getPage($vmId, $page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v1/vms/' . $vmId . '/tags', $page, $perPage, $filters);

        $page->serializeWith(function ($item) {

        });
    }

    public function serializeData($raw)
    {
        return new VirtualMachineTag($this->apiToFriendly($raw, self::VM_TAG_MAP));
    }
}

<?php

namespace UKFast\PHaaS;

use UKFast\Page;
use UKFast\Client as BaseClient;
use UKFast\PHaaS\Entities\Campaign;
use UKFast\PHaaS\Entities\CampaignResults;
use UKFast\PHaaS\Entities\CampaignUserResults;

class CampaignClient extends BaseClient
{
    protected $basePath = 'phaas/';

    /**
     * Get a paginated list of domains
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $campaigns = $this->paginatedRequest('v1/campaigns', $page, $perPage, $filters);

        $campaigns->serializeWith(function ($item) {
            return new Campaign($item);
        });

        return $campaigns;
    }

    /**
     * Create a new PHishing Campaign
     *
     * @param array $campaign
     * @return Campaign
     */
    public function createCampaign($campaign)
    {
        $response = $this->request(
            'POST',
            'v1/campaigns',
            json_encode($campaign)
        );

        $campaign = $this->decodeJson($response->getBody()->getContents());

        return new Campaign($campaign->data);
    }

    /**
     * Get a campaign by id
     *
     * @param string $id
     * @return Campaign
     */
    public function getCampaign($id)
    {
        $response = $this->request('GET', 'v1/campaigns/' . $id);

        $campaign = $this->decodeJson($response->getBody()->getContents());

        return new Campaign($campaign->data);
    }

    /**
     * Get campaign results overview by id
     *
     * @param string $id
     * @return CampaignResults
     */
    public function getCampaignResultsOverview($id)
    {
        $response = $this->request('GET', 'v1/campaigns/results/overview/' . $id);

        $campaign = $this->decodeJson($response->getBody()->getContents());

        return new CampaignResults($campaign->data);
    }

    /**
     * Get campaign results overview by id
     *
     * @param string $id
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     */
    public function getCampaignResultsUsers($id, $page = 1, $perPage = 15, $filters = [])
    {
        $results = $this->paginatedRequest('v1/campaigns/results/users/' . $id, $page, $perPage, $filters);

        $results->serializeWith(function ($item) {
            return new CampaignUserResults($item);
        });

        return $results;
    }
}

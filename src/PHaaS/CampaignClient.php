<?php

namespace UKFast\SDK\PHaaS;

use UKFast\SDK\Page;
use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\PHaaS\Entities\Campaign;
use UKFast\SDK\PHaaS\Entities\CampaignResults;
use UKFast\SDK\PHaaS\Entities\CampaignUserResults;

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
     * @throws \GuzzleHttp\Exception\GuzzleException
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
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function createCampaign($campaign)
    {
        $response = $this->post(
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
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getCampaign($id)
    {
        $response = $this->get('v1/campaigns/' . $id);

        $campaign = $this->decodeJson($response->getBody()->getContents());

        return new Campaign($campaign->data);
    }

    /**
     * Get campaign results overview by id
     *
     * @param string $id
     * @return CampaignResults
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getCampaignResultsOverview($id)
    {
        $response = $this->get("v1/campaigns/$id/results/overview");

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
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getCampaignResultsUsers($id, $page = 1, $perPage = 15, $filters = [])
    {
        $results = $this->paginatedRequest("v1/campaigns/$id/results/users/", $page, $perPage, $filters);

        $results->serializeWith(function ($item) {
            return new CampaignUserResults($item);
        });

        return $results;
    }
}

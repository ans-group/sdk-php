<?php

namespace UKFast\SDK\DDoSX;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\DDoSX\Entities\Waf;
use UKFast\SDK\DDoSX\Entities\WafAdvancedRule;
use UKFast\SDK\DDoSX\Entities\WafRule;
use UKFast\SDK\DDoSX\Entities\WafRuleset;
use UKFast\SDK\SelfResponse;

class WafClient extends BaseClient
{
    /**
     * @inheritDoc
     */
    protected $basePath = 'ddosx/';

    const WAF_MAP = [
        "domain_name" => "name",
        "paranoia_level" => "paranoia"
    ];

    const RULE_MAP = [];
    const ADVANCED_RULE_MAP = [];
    const RULESET_MAP = [];

    /**
     * @param Waf $waf
     * @return SelfResponse
     */
    public function create(Waf $waf)
    {
        $response = $this->post(
            'v1/domains/' . $waf->name . '/waf',
            json_encode($this->friendlyToApi($waf, self::WAF_MAP))
        );
        $body = $this->decodeJson($response->getBody()->getContents());

        return (new SelfResponse($body, "domain_name"))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return new Waf($this->apiToFriendly($response->data, self::WAF_MAP));
            });
    }

    /**
     * Gets the WAF settings for the domain
     * @param $domainName
     * @return Waf
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getByDomainName($domainName)
    {
        $response = $this->get('v1/domains/' . $domainName . '/waf');

        $body = $this->decodeJson($response->getBody()->getContents());

        return $this->serializeData($body->data);
    }

    /**
     * Get a paginated response of rules for a domain
     * @param $domainName
     * @param $page
     * @param $perPage
     * @param array $filters
     * @return \UKFast\SDK\Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getRules($domainName, $page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v1/domains/' . $domainName . '/waf/rules', $page, $perPage, $filters);

        $page->serializeWith(function ($item) {
            return $this->serializeRule($item);
        });

        return $page;
    }

    /**
     * Get the rule for a domain by it's ID
     * @param $domainName
     * @param $ruleId
     * @return WafRule
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getRuleById($domainName, $ruleId)
    {
        $response = $this->get('v1/domains/' . $domainName . '/waf/rules/' . $ruleId);
        $body = $this->decodeJson($response->getBody()->getContents());

        return $this->serializeRule($body->data);
    }

    /**
     * Get a paginated response of advanced rules for a domain
     * @param $domainName
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return int|\UKFast\SDK\Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAdvancedRules($domainName, $page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest(
            'v1/domains/' . $domainName . '/waf/advanced-rules',
            $page,
            $perPage,
            $filters
        );

        $page->serializeWith(function ($item) {
            return $this->serializeAdvancedRule($item);
        });

        return $page;
    }

    /**
     * Get an advanced rule for a domain by it's ID
     * @param $domainName
     * @param $ruleId
     * @return WafAdvancedRule
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAdvancedRuleById($domainName, $ruleId)
    {
        $response = $this->get('v1/domains/' . $domainName . '/waf/advanced-rules/' . $ruleId);
        $body = $this->decodeJson($response->getBody()->getContents());

        return $this->serializeAdvancedRule($body->data);
    }

    /**
     * Get the rulesets for a domain
     * @param $domainName
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getRulesets($domainName)
    {
        $response = $this->get('v1/domains/' . $domainName . '/waf/rulesets');

        $body = $this->decodeJson($response->getBody()->getContents());

        return array_map(function ($item) {
            return $this->serializeRuleset($item);
        }, $body->data);
    }

    protected function serializeWaf($raw)
    {
        return new Waf($this->apiToFriendly($raw, self::WAF_MAP));
    }

    protected function serializeRule($raw)
    {
        return new WafRule($this->apiToFriendly($raw, self::RULE_MAP));
    }

    protected function serializeAdvancedRule($raw)
    {
        return new WafAdvancedRule($this->apiToFriendly($raw, self::RULE_MAP));
    }

    protected function serializeRuleset($raw)
    {
        return new WafRuleset($this->apiToFriendly($raw, self::RULESET_MAP));
    }
}

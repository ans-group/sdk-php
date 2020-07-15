<?php
/**
 * @author: John Birch-Evans <john.birch-evans@ukfast.co.uk>
 * @copyright: 2020 UKFast.net Ltd
 */

namespace UKFast\SDK\ThreatMonitoring\Reporting;

use UKFast\SDK\ThreatMonitoring\Client;
use UKFast\SDK\ThreatMonitoring\Entities\EventsOverview;
use UKFast\SDK\ThreatMonitoring\Entities\EventsTimeline;
use UKFast\SDK\ThreatMonitoring\Entities\EventsTotal;

class EventsClient extends Client
{
    const EVENT_TOTAL_MAP = [];
    const EVENT_OVERVIEW_MAP = [];
    const EVENT_TIMELINE_MAP = [];

    /**
     * Get the total number of events for a  client
     * @param array $filters
     * @return EventsTotal
     */
    public function getTotal($filters = [])
    {
        $queryParams = '';

        if (count($filters) > 0) {
            $queryParams = '?' . http_build_query($filters);
        }

        $response = $this->get('v1/reports/events/total' . $queryParams);

        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->serializeEventsTotal($body->data);
    }

    /**
     * Get the events overview for a client
     * @param array $filters
     * @return array
     */
    public function getOverview($filters = [])
    {
        $queryParams = '';

        if (count($filters) > 0) {
            $queryParams = '?' . http_build_query($filters);
        }

        $response = $this->get('v1/reports/events/overview' . $queryParams);

        $body = $this->decodeJson($response->getBody()->getContents());

        return array_map(function ($item) {
            return $this->serializeEventsOverview($item);
        }, $body->data);
    }

    /**
     * Get the timeline of events
     * @param array $filters
     * @return array
     */
    public function getTimeline($filters = [])
    {
        $queryParams = '';

        if (count($filters) > 0) {
            $queryParams = '?' . http_build_query($filters);
        }

        $response = $this->get('v1/reports/events/timeline' . $queryParams);

        $body = $this->decodeJson($response->getBody()->getContents());

        return array_map(function ($item) {
            return $this->serializeEventsTimeline($item);
        }, $body->data);
    }

    public function serializeEventsTotal($data)
    {
        return new EventsTotal($this->apiToFriendly($data, static::EVENT_TOTAL_MAP));
    }

    public function serializeEventsOverview($data)
    {
        return new EventsOverview($this->apiToFriendly($data, static::EVENT_OVERVIEW_MAP));
    }

    public function serializeEventsTimeline($data)
    {
        return new EventsTimeline($this->apiToFriendly($data, static::EVENT_TIMELINE_MAP));
    }
}

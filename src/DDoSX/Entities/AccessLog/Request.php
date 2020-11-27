<?php

namespace UKFast\SDK\DDoSX\Entities\AccessLog;

use UKFast\SDK\Entity;

/**
 * @property string       $host
 * @property string       $path
 * @property string|null  $referrer
 * @property string       $userAgent
 * @property  float       $httpVersion
 * @property RequestSsl   $ssl
 * @property string       $clientIp
 * @property RequestGeoip $geoip
 */
class Request extends Entity
{
    //
}

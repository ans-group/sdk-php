<?php

namespace UKFast\SDK\DDoSX\Entities;

use UKFast\SDK\Entity;
use UKFast\SDK\Exception\UKFastException;

/**
 * @property GuzzleHttp\Psr7\Response $response
 */
class VerificationFile extends Entity
{
    /**
     * Get a stream of the verification file's body
     *
     * @return \GuzzleHttp\Psr7\Stream
     */
    public function getStream()
    {
        return $this->response->getBody();
    }

    /**
     * Get the verification file's name
     *
     * @return string
     * @throws \UKFast\SDK\Exception\UKFastException
     */
    public function getName()
    {
        $filenameMatch = preg_match('/filename="([[:alnum:]]+\.[[:alnum:]]+)"/', $this->response->getHeaders()['Content-Disposition'][0], $filename);

        if ($filenameMatch === false || empty($filename[1])) {
            throw new UKFastException('Invalid filename');
        }
        return $filename[1];
    }
}

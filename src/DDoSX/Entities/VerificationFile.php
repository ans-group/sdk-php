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
        $contentDisposition = array_change_key_case($this->response->getHeaders())['content-disposition'][0];
        $filenameMatch      = preg_match('/filename="([[:alnum:]]+\.[[:alnum:]]+)"/', $contentDisposition, $filename);

        if ($filenameMatch === false || empty($filename[1])) {
            throw new UKFastException('Invalid filename');
        }
        return $filename[1];
    }

    /**
     * @return string|boolean
     */
    public function getContentType()
    {
        $contentType = array_change_key_case($this->response->getHeaders())['content-type'][0];
        if (empty($contentType) === false) {
            return $contentType;
        }

        return false;
    }
}

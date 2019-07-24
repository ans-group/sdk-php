<?php

namespace UKFast\SDK\PSS;

use UKFast\SDK\SelfResponse;

class AttachmentSelfResponse extends SelfResponse
{
    /**
     * Get the contet of the attachment
     * @return mixed
     */
    public function get()
    {
        $response = $this->client->request("GET", $this->getLocation());
        $response->getBody()->rewind();
        $body = $response->getBody();

        $serializer = $this->serializer;
        if ($serializer) {
            return $serializer($body);
        }

        return $body->getContents();
    }
}

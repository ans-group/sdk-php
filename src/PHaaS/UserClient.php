<?php

namespace UKFast\PHaaS;

use Psr\Http\Message\ResponseInterface;
use UKFast\Page;
use UKFast\Client as BaseClient;
use UKFast\PHaaS\Entities\User;

class UserClient extends BaseClient
{
    protected $basePath = 'phaas/';

    /**
     * Get a paginated list of users
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v1/users', $page, $perPage, $filters);

        $page->serializeWith(function ($item) {
            return new User($item);
        });

        return $page;
    }

    /**
     * Bulk add an array of users
     *
     * @param array $users
     * @return array|ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function addUsers($users)
    {
        $payload = json_encode([
            'users' => $users
        ]);

        $response = $this->post(
            'v1/users/bulk-upload',
            $payload
        );

        $users = $this->decodeJson($response->getBody()->getContents());

        $response = [];

        foreach ($users->data as $user) {
            if (isset($user->messages)) {
                $response['messages'] = $user->messages;
                continue;
            }
            $response[] = new User($user);
        }

        return $response;
    }

    /**
     * Add a single user
     *
     * @param $user
     * @return User
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function addUser($user)
    {
        $payload = json_encode($user);

        $response = $this->post(
            'v1/users',
            $payload
        );

        $response = $this->decodeJson($response->getBody()->getContents());

        return new User($response->data);
    }

    /**
     * Remove a user by id
     *
     * @param $id
     * @return ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function removeUser($id)
    {
        $response = $this->delete('v1/users/' . $id);

        return $response;
    }
}

<?php

namespace TestAPI;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;
use TestAPI\Exceptions\ClientNotFoundException;

class TestAPI
{
    /**
     * @var mixed
     */
    private static $API_TOKEN;

    private $httpService;

    /**
     * TestAPI constructor.
     * @param Client $httpService
     */
    public function __construct(Client $httpService)
    {
        $this->httpService = $httpService;
        $this->auth();
    }

    /**
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function auth()
    {
        $body = ['login' => getenv('TEST_API_USER'), 'pass' => getenv('TEST_API_PASSWORD')];
        try {
            $response = $this->httpService->get(getenv('TEST_API_URL') . 'auth', $body);
        } catch (RequestException $exception) {
            return false;
        }

        self::$API_TOKEN = $this->getResponseObjects($response)['token'];

        return true;
    }

    /**
     * @param string $userName
     * @return mixed|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getUser(string $userName)
    {
        $body = ['username' => $userName, 'token' => self::$API_TOKEN];
        try {
            $response = $this->httpService->get(getenv('TEST_API_URL') . 'get-user', $body);
            return $this->getResponseObjects($response);
        } catch (RequestException $exception) {
            return $exception->getResponse()->getReasonPhrase();
        }
    }

    /**
     * @param string $userName
     * @param array $jsonFields
     * @return mixed|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function setUser(string $userName, array $jsonFields)
    {
        $body['json'] = $jsonFields;
        $body['query'] = ['token' => self::$API_TOKEN];

        try {
            $response = $this->httpService->post(getenv('TEST_API_URL') . 'user/' . $userName . '/update', $body);
            return $this->getResponseObjects($response);
        } catch (RequestException $exception) {
            return $exception->getResponse()->getReasonPhrase();
        }
    }

    /**
     * @param Response $response
     * @return mixed
     */
    private function getResponseObjects(Response $response)
    {
        return json_decode($response->getBody()->getContents(), true);
    }


}
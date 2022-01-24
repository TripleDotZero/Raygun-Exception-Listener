<?php

namespace RaygunFilterParams;

use GuzzleHttp\Client as HttpClient;
use Raygun4php\RaygunClient;
use Raygun4php\Transports\GuzzleAsync;
use Raygun4php\Transports\GuzzleSync;
use Throwable;

class DataFilter
{
    /**
     * @var Config
     */
    private $config;

    /**
     * DataFilter constructor.
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param Throwable $throwable
     * @param array|null $tags
     * @param array|null $customUserData
     * @param int|null $timestamp
     */
    public function sendExceptionToRaygun(
        Throwable $throwable,
        array $tags = null,
        array $customUserData = null,
        int $timestamp = null
    ): void {
        if (in_array($throwable, $this->config->getIgnoredExceptions())) {
            return;
        }

        $raygunClient = $this->getRaygunClient($this->config);
        $this->setFilterParams($raygunClient);
        $raygunClient->SendException($throwable, $tags, $customUserData, $timestamp);
    }

    /**
     * @param int $errCode
     * @param string $errMessage
     * @param string $errFile
     * @param int $errLine
     * @param null $tags
     * @param null $customUserData
     * @param null $timestamp
     */
    public function sendErrorToRaygun(
        int $errCode,
        string $errMessage,
        string $errFile,
        int $errLine,
        $tags = null,
        $customUserData = null,
        $timestamp = null
    ): void {
        $raygunClient = $this->getRaygunClient($this->config);
        $this->setFilterParams($raygunClient);
        $raygunClient->SendError($errCode, $errMessage, $errFile, $errLine, $tags, $customUserData, $timestamp);
    }


    /**
     * @param RaygunClient $client
     */
    private function setFilterParams(RaygunClient $client)
    {
        $filtered = [];
        foreach ($this->config->getFilters() as $filter) {
            $filtered[$filter] = true;
        }
        $client->setFilterParams($filtered);
    }

    /**
     * @param Config $config
     * @return RaygunClient
     */
    private function getRaygunClient(Config $config): RaygunClient
    {
        $httpClient = $this->getHttpClient($config);
        $raygunClient = new RaygunClient($this->getGuzzleTransport($config, $httpClient));

        if ($config->getUserTracking()) {
            $raygunClient->setDisableUserTracking(true);
        }

        if ($config->getUser()) {
            $raygunClient->setUserIdentifier($config->getUser());
        }

        return $raygunClient;
    }

    /**
     * @param Config $config
     * @return HttpClient
     */
    private function getHttpClient(Config $config): HttpClient
    {
        $httpConfig = [
            'base_uri' => $config->getBaseUrl(),
            'headers' => ['X-ApiKey' => $config->getApiKey()]
        ];

        if ($config->getProxy()) {
            $httpConfig['proxy'] = $config->getProxy();
        }

        return new HttpClient($httpConfig);
    }

    /**
     * @param Config $config
     * @param HttpClient $httpClient
     * @return GuzzleAsync|GuzzleSync
     */
    private function getGuzzleTransport(Config $config, HttpClient $httpClient)
    {
        if ($config->getUseAsync()) {
            return new GuzzleAsync($httpClient);
        } else {
            return new GuzzleSync($httpClient);
        }
    }
}

<?php

namespace RaygunFilterParams;

use Raygun4php\RaygunIdentifier;

class Config
{
    private $baseUrl;
    private $apiKey;
    private $proxy;
    private $userTracking;
    private $useAsync;
    private $user;

    private $filters = [
        '/secret/i',
        '/key/i',
        '/token/i',
        '/auth/i',
        '/card/i',
        '/dns/i',
        '/mac/i',
        '/imei/i',

        '/password/i',
        '/passwd/i',
        '/pwd/i',
        '/email/i',
        '/(?!user(-|_)agent)user/i',
        '/name/i',
        '/address/i',
        '/street/i',
        '/city/i',

        '/identity/i',
        '/id/i',
        '/credential/i',
        '/creds/i',
        '/licence/i'
    ];
    private $ignoredExceptions = [];

    /**
     * Config constructor.
     * @param string|null $baseUrl
     * @param string|null $apiKey
     */
    public function __construct(?string $baseUrl, ?string $apiKey)
    {
        $this->baseUrl = $baseUrl;
        $this->apiKey = $apiKey;
        $this->proxy = "";
        $this->userTracking = false;
        $this->useAsync = false;
    }

    /**
     * @return string[]
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    /**
     * @param string[] $filters
     */
    public function setFilters(array $filters): void
    {
        $this->filters = $filters;
    }

    /**
     * Add string to list of filters, by turing the string into a regex
     * @param string $string
     */
    public function addToFilter(string $string): void
    {
        $this->filters[] = '/' . $string . '/i';
    }

    /**
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * @param string|null $apiKey
     */
    public function setApiKey(?string $apiKey): void
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * @param string|null $baseUrl
     */
    public function setBaseUrl(?string $baseUrl): void
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * @return string
     */
    public function getProxy(): string
    {
        return $this->proxy;
    }

    /**
     * @param string $proxy
     */
    public function setProxy(string $proxy): void
    {
        $this->proxy = $proxy;
    }

    /**
     * @return bool
     */
    public function getUserTracking(): bool
    {
        return $this->userTracking;
    }

    /**
     * @param bool $userTracking
     */
    public function setUserTracking(bool $userTracking): void
    {
        $this->userTracking = $userTracking;
    }

    /**
     * @return bool
     */
    public function getUseAsync(): bool
    {
        return $this->useAsync;
    }

    /**
     * @param bool $useAsync
     */
    public function setUseAsync(bool $useAsync): void
    {
        $this->useAsync = $useAsync;
    }

    /**
     * @param RaygunIdentifier $user
     */
    public function setUser(RaygunIdentifier $user): void
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return array
     */
    public function getIgnoredExceptions(): array
    {
        return $this->ignoredExceptions;
    }

    /**
     * @param array $ignoredExceptions
     */
    public function setIgnoredExceptions(array $ignoredExceptions): void
    {
        $this->ignoredExceptions = $ignoredExceptions;
    }

    /**
     * Add given class to list if ignoredClasses
     * @param $exception
     */
    public function addToIgnoredExceptions($exception): void
    {
        array_push($this->ignoredExceptions, $exception);
    }
}

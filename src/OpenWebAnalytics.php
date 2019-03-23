<?php
/**
 * Part of the Open Web Analytics PHP REST Client package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Open Web Analytics PHP REST Client
 * @version    0.1.3
 * @author     VerdeIT
 * @license    BSD License (3-clause)
 * @copyright  (c) 2019-2019, VerdeIT
 * @link       https://github.com/hafael/owa-php-client
 */

namespace Hafael\OpenWebAnalytics;


class OpenWebAnalytics
{
    /**
     * The package version.
     *
     * @var string
     */
    const VERSION = '0.1.3';

    /**
     * The Config repository instance.
     *
     * @var \Hafael\OpenWebAnalytics\ConfigInterface
     */
    protected $config;

    /**
     * The amount converter class and method name.
     *
     * @var string
     */
    protected static $amountConverter = '\\Hafael\\OpenWebAnalytics\\AmountConverter::convert';

    /**
     * Constructor.
     *
     * @param string $baseUrl
     * @param string $apiKey
     * @param string $siteId
     * @param string $format
     */
    public function __construct($baseUrl = null, $apiKey = null, $siteId= null, $format = 'json')
    {
        $this->config = new Config(self::VERSION, $baseUrl, $apiKey, $siteId, $format);
    }

    /**
     * Create a new Open Web Analytics API instance.
     *
     * @param  string $baseUrl
     * @param  string $apiKey
     * @param  string $siteId
     * @param  string $format
     * @return OpenWebAnalytics
     */
    public static function make($baseUrl = null, $apiKey = null, $siteId= null, $format = null)
    {
        return new static($baseUrl, $apiKey, $siteId, $format);
    }

    /**
     * Returns the current package version.
     *
     * @return string
     */
    public static function getVersion()
    {
        return self::VERSION;
    }

    /**
     * Returns the Config repository instance.
     *
     * @return \Hafael\OpenWebAnalytics\ConfigInterface
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Sets the Config repository instance.
     *
     * @param  \Hafael\OpenWebAnalytics\ConfigInterface  $config
     * @return $this
     */
    public function setConfig(ConfigInterface $config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Returns the Open Web Analytics base URL.
     *
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->config->getBaseUrl();
    }

    /**
     * Sets the Open Web Analytics base URL.
     *
     * @param  string  $baseUrl
     * @return $this
     */
    public function setBaseUrl($baseUrl)
    {
        $this->config->setBaseUrl($baseUrl);

        return $this;
    }

    /**
     * Returns the Open Web Analytics API key.
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->config->getApiKey();
    }

    /**
     * Sets the Open Web Analytics API key.
     *
     * @param  string  $apiKey
     * @return $this
     */
    public function setApiKey($apiKey)
    {
        $this->config->setApiKey($apiKey);

        return $this;
    }

    /**
     * Returns the Open Web Analytics Site ID.
     *
     * @return string
     */
    public function getSiteId()
    {
        return $this->config->getSiteId();
    }

    /**
     * Sets the Open Web Analytics Site ID.
     *
     * @param  string  $siteId
     * @return $this
     */
    public function setSiteId($siteId)
    {
        $this->config->getSiteId($siteId);

        return $this;
    }

    /**
     * Returns the response format.
     *
     * @return string
     */
    public function getFormat()
    {
        return $this->config->getFormat();
    }

    /**
     * Sets the response format.
     *
     * @param  string $format
     * @return $this
     */
    public function setFormat($format)
    {
        $this->config->setFormat($format);

        return $this;
    }


    /**
     * Dynamically handle missing methods.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return \Hafael\OpenWebAnalytics\Api\ApiInterface
     */
    public function __call($method, array $parameters)
    {
        if ($this->isIteratorRequest($method)) {
            $apiInstance = $this->getApiInstance(substr($method, 0, -8));

            return (new Pager($apiInstance))->fetch($parameters);
        }

        return $this->getApiInstance($method);
    }

    /**
     * Determines if the request is an iterator request.
     *
     * @return bool
     */
    protected function isIteratorRequest($method)
    {
        return substr($method, -8) === 'Iterator';
    }

    /**
     * Returns the Api class instance for the given method.
     *
     * @param  string  $method
     * @return \Hafael\OpenWebAnalytics\Api\ApiInterface
     * @throws \BadMethodCallException
     */
    protected function getApiInstance($method)
    {
        $class = "\\Hafael\\OpenWebAnalytics\\Api\\".ucwords($method);

        if (class_exists($class)) {
            return new $class($this->config);
        }

        throw new \BadMethodCallException("Undefined method [{$method}] called.");
    }

}
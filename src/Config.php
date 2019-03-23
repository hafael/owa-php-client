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
 * @version    0.1.2
 * @author     VerdeIT
 * @license    BSD License (3-clause)
 * @copyright  (c) 2019-2019, VerdeIT
 * @link       https://github.com/hafael/owa-php-client
 */

namespace Hafael\OpenWebAnalytics;


class Config implements ConfigInterface
{
    /**
     * The current package version.
     *
     * @var string
     */
    protected $version;

    /**
     * The required Open Web Analytics API Key to access this service.
     * (e.g. "8ab9dc3ffcdac576d0f298043a60517a")
     *
     * @var string
     */
    protected $apiKey;

    /**
     * The required site id to identify your Website.
     * (e.g. "9731fd106063512b2f10ea66cc943aa2")
     *
     * @var string
     */
    protected $siteId;

    /**
     * The required Open Web Analytics server base url.
     * (e.g. "http://demo.openwebanalytics.com")
     *
     * @var string
     */
    protected $baseUrl;

    /**
     * The response document format.
     *
     * @var string
     */
    protected $format;

    /**
     * Constructor.
     *
     * @param  string $version
     * @param  string $baseUrl
     * @param  string $apiKey
     * @param  string $siteId
     * @param  string $format
     */
    public function __construct($version, $baseUrl, $apiKey, $siteId, $format)
    {
        $this->setVersion($version);
        $this->setBaseUrl($baseUrl);
        $this->setFormat($format ?: 'json');
        $this->setApiKey($apiKey);
        $this->setSiteId($siteId);

        if (! $this->apiKey || ! $this->siteId) {
            throw new \RuntimeException('The Open Web Analytics API key or Site ID is not defined!');
        }
        
        
    }

    /**
     * {@inheritdoc}
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * {@inheritdoc}
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * {@inheritdoc}
     */
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * {@inheritdoc}
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSiteId()
    {
        return $this->siteId;
    }

    /**
     * {@inheritdoc}
     */
    public function setSiteId($siteId)
    {
        $this->siteId = $siteId;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * {@inheritdoc}
     */
    public function setFormat($format)
    {
        $this->format = $format;

        return $this;
    }


}
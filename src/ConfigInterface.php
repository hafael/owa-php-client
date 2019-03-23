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
 * @version    0.1.4
 * @author     VerdeIT
 * @license    BSD License (3-clause)
 * @copyright  (c) 2019-2019, VerdeIT
 * @link       https://github.com/hafael/owa-php-client
 */

namespace Hafael\OpenWebAnalytics;


interface ConfigInterface
{
    /**
     * Returns the current package version.
     *
     * @return string
     */
    public function getVersion();

    /**
     * Sets the current package version.
     *
     * @param  string  $version
     * @return $this
     */
    public function setVersion($version);

    /**
     * Returns the current Open Web Analytics server base URL.
     *
     * @return string
     */
    public function getBaseUrl();

    /**
     * Sets the current current Open Web Analytics server base URL.
     *
     * @param  string  $baseUrl
     * @return $this
     */
    public function setBaseUrl($baseUrl);

    /**
     * Returns the Open Web Analytics API key.
     *
     * @return string
     */
    public function getApiKey();

    /**
     * Sets the Open Web Analytics API key.
     *
     * @param  string  $apiKey
     * @return $this
     */
    public function setApiKey($apiKey);

    /**
     * Returns the Open Web Analytics Site ID.
     *
     * @return string
     */
    public function getSiteId();

    /**
     * Sets the Open Web Analytics Site ID.
     *
     * @param  string  $siteId
     * @return $this
     */
    public function setSiteId($siteId);

    /**
     * Returns the format response.
     *
     * @return string
     */
    public function getFormat();

    /**
     * Sets the format response.
     * Can be json, XML, PHP, HTML, debug (PHP var_dump()).
     *
     * @param  string  $format
     * @return $this
     */
    public function setFormat($format);
}
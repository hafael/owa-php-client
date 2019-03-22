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
 * @version    0.1.0
 * @author     VerdeIT
 * @license    BSD License (3-clause)
 * @copyright  (c) 2019-2019, VerdeIT
 * @link       https://github.com/hafael/owa-php-client
 */

namespace Hafael\OpenWebAnalytics\Api;


interface ApiInterface
{
    /**
     * Returns the Open Web Analytics API base url.
     *
     * @return string
     */
    public function baseUrl();

    /**
     * Returns the constraints array.
     *
     * @return void
     */
    public function getConstraints();

    /**
     * Returns the constraints parsed and urlencoded.
     *
     * @return void
     */
    public function getParsedConstraints();

    /**
     * Sets the constraints.
     *
     * @param  string  $name
     * @param  string  $operator
     * @param  string  $expression
     * @return $this
     */
    public function setConstraint($name, $operator, $expression);

    /**
     * Returns the number of items to return per page.
     *
     * @return void
     */
    public function getPerPage();

    /**
     * Sets the number of items to return per page.
     *
     * @param  int  $perPage
     * @return $this
     */
    public function setPerPage($perPage);

    /**
     * Returns the 0-Based index to specify with which item to start the result.
     *
     * @return void
     */
    public function getOffset();

    /**
     * Sets 0-Based index to specify with which item to start the result - useful for paging.
     *
     * @param  int  $offset
     * @return $this
     */
    public function setOffset($offset);

    /**
     * Returns the sort ordenation.
     *
     * @return void
     */
    public function getSort();

    /**
     * Sets the sort ordenation.
     *
     * @param  string  $sort
     * @return $this
     */
    public function setSort($sort = null);

    /**
     * Returns the segment.
     *
     * @return void
     */
    public function getSegment();

    /**
     * Sets the segment.
     *
     * @param  string  $segment
     * @return $this
     */
    public function setSegment($segment = null);

    /**
     * Returns the response format.
     *
     * @return void
     */
    public function getFormat();

    /**
     * Sets the response format.
     *
     * @param  string  $format
     * @return $this
     */
    public function setFormat($format = 'json');

    /**
     * Send a GET request.
     *
     * @param  string  $url
     * @param  array  $parameters
     * @return array
     */
    public function _get($url = null, $parameters = []);

    /**
     * Send a HEAD request.
     *
     * @param  string  $url
     * @param  array  $parameters
     * @return array
     */
    public function _head($url = null, array $parameters = []);

    /**
     * Send a DELETE request.
     *
     * @param  string  $url
     * @param  array  $parameters
     * @return array
     */
    public function _delete($url = null, array $parameters = []);

    /**
     * Send a PUT request.
     *
     * @param  string  $url
     * @param  array  $parameters
     * @return array
     */
    public function _put($url = null, array $parameters = []);

    /**
     * Send a PATCH request.
     *
     * @param  string  $url
     * @param  array  $parameters
     * @return array
     */
    public function _patch($url = null, array $parameters = []);

    /**
     * Send a POST request.
     *
     * @param  string  $url
     * @param  array  $parameters
     * @return array
     */
    public function _post($url = null, array $parameters = []);

    /**
     * Send an OPTIONS request.
     *
     * @param  string  $url
     * @param  array  $parameters
     * @return array
     */
    public function _options($url = null, array $parameters = []);

    /**
     * Executes the HTTP request.
     *
     * @param  string  $httpMethod
     * @param  string  $url
     * @param  array  $parameters
     * @return array
     */
    public function execute($httpMethod, $url, array $parameters = []);
}
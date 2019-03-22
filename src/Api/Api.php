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

use GuzzleHttp\Client;
use GuzzleHttp\Middleware;
use GuzzleHttp\HandlerStack;
use Hafael\OpenWebAnalytics\Utility;
use Hafael\OpenWebAnalytics\ConfigInterface;
use Psr\Http\Message\RequestInterface;
use Hafael\OpenWebAnalytics\Exception\Handler;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\TransferException;

abstract class Api implements ApiInterface
{
    /**
     * The Config repository instance.
     *
     * @var \Hafael\OpenWebAnalytics\ConfigInterface
     */
    protected $config;

    /**
     * The constraints.
     *
     * @var null|array
     */
    protected $constraints = [];

    /**
     * Number of items to return per page.
     *
     * @var null|int
     */
    protected $perPage;

    /**
     * 0-Based index to specify with which item to start the result - useful for paging.
     *
     * @var null|int
     */
    protected $offset;

    /**
     * Sort description
     *
     * @var null|string
     */
    protected $sort;

    /**
     * Segment description
     *
     * @var null|string
     */
    protected $segment;

    /**
     * Constructor.
     *
     * @param  \Hafael\OpenWebAnalytics\ConfigInterface  $client
     * @return void
     */
    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function baseUrl()
    {
        return $this->config->getBaseUrl();
    }

    /**
     * {@inheritdoc}
     */
    public function getConstraints()
    {
        return $this->constraints;
    }

    /**
     * {@inheritdoc}
     */
    public function getParsedConstraints()
    {
        $constraint = '';
        $len = count($this->constraints);
        foreach($this->constraints as $key => $constraint) {
            $constraint .= $constraint['name'].urlencode($constraint['operator']).$constraint['expression'];
            if($key != $len - 1) {
                $constraint .= ',';
            }
        }
        return $constraint;
    }

    /**
     * {@inheritdoc}
     */
    public function setConstraint($name, $operator, $expression)
    {
        $this->constraints->push([
            'name' => $name,
            'operator' => $operator,
            'expression' => $expression
        ]);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPerPage()
    {
        return $this->perPage;
    }

    /**
     * {@inheritdoc}
     */
    public function setPerPage($perPage)
    {
        $this->perPage = (int) $perPage;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOffset()
    {
        return $this->perPage;
    }

    /**
     * {@inheritdoc}
     */
    public function setOffset($offset)
    {
        $this->offset = (int) $offset;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getFormat()
    {
        return $this->config->getFormat();
    }

    /**
     * {@inheritdoc}
     */
    public function setFormat($format = 'json')
    {
        $this->config->setFormat($format);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * {@inheritdoc}
     */
    public function setSort($sort)
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSegment()
    {
        return $this->segment;
    }

    /**
     * {@inheritdoc}
     */
    public function setSegment($segment)
    {
        $this->segment = $segment;

        return $this;
    }


    /**
     * {@inheritdoc}
     */
    public function _get($url = null, $parameters = [])
    {
        if ($perPage = $this->getPerPage()) {
            $parameters['owa_limit'] = $perPage;
        }

        return $this->execute('get', $url, $parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function _head($url = null, array $parameters = [])
    {
        return $this->execute('head', $url, $parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function _delete($url = null, array $parameters = [])
    {
        return $this->execute('delete', $url, $parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function _put($url = null, array $parameters = [])
    {
        return $this->execute('put', $url, $parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function _patch($url = null, array $parameters = [])
    {
        return $this->execute('patch', $url, $parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function _post($url = null, array $parameters = [])
    {
        return $this->execute('post', $url, $parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function _options($url = null, array $parameters = [])
    {
        return $this->execute('options', $url, $parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function execute($httpMethod, $url, array $parameters = [])
    {
        try {
            $parameters = array_merge($parameters, [
                'owa_apiKey' => isset($parameters['apiKey'])?$parameters['apiKey']:$this->config->getApiKey(),
                'owa_siteId' => isset($parameters['siteId'])?$parameters['siteId']:$this->config->getSiteId(),
                'owa_format' => isset($parameters['format'])?$parameters['format']:$this->config->getFormat(),
            ]);

            $parameters = Utility::transformArrayIntoHttpQuery($parameters);

            $response = $this->getClient()->{$httpMethod}($url, [ 'query' => $parameters ]);

            return json_decode((string) $response->getBody(), true);
        } catch (ClientException $e) {
            new Handler($e);
        }
    }

    /**
     * Returns an Http client instance.
     *
     * @return \GuzzleHttp\Client
     */
    protected function getClient()
    {
        return new Client([
            'base_uri' => $this->baseUrl(), 'handler' => $this->createHandler()
        ]);
    }

    /**
     * Create the client handler.
     *
     * @return \GuzzleHttp\HandlerStack
     */
    protected function createHandler()
    {
        $stack = HandlerStack::create();

        $stack->push(Middleware::mapRequest(function (RequestInterface $request) {
            return $request;
        }));

        $stack->push(Middleware::retry(function ($retries, RequestInterface $request, ResponseInterface $response = null, TransferException $exception = null) {
            return $retries < 3 && ($exception instanceof ConnectException || ($response && $response->getStatusCode() >= 500));
        }, function ($retries) {
            return (int) pow(2, $retries) * 1000;
        }));

        return $stack;
    }
}
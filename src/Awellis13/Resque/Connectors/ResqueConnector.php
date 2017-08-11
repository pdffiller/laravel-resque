<?php namespace Awellis13\Resque\Connectors;

use Awellis13\Resque\ResqueQueue;
use Config;
use Illuminate\Queue\Connectors\ConnectorInterface;
use Resque;

/**
 * Class ResqueConnector
 *
 * @package Resque\Connectors
 */
class ResqueConnector implements ConnectorInterface
{

    /**
     * Establish a queue connection.
     *
     * @param array $config
     * @return  \Illuminate\Contracts\Queue\Queue
     */
    public function connect(array $config)
    {
        if (!isset($config['host'])) {
            $config = Config::get('database.redis.default');

            if (!isset($config['host'])) {
                $config['host'] = '127.0.0.1';
            }
        }

        if (!isset($config['port'])) {
            $config['port'] = 6379;
        }

        if (!isset($config['database'])) {
            $config['database'] = 0;
        }

        Resque::setBackend($config['host'] . ':' . $config['port'], $config['database']);

        return new ResqueQueue;
    }

} // End ResqueConnector

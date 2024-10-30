<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MantiqVendors\Symfony\Contracts\Service;

/**
 * A ServiceSubscriber exposes its dependencies via the static {@link getSubscribedServices} method.
 *
 * The getSubscribedServices method returns an array of service types required by such instances,
 * optionally keyed by the service names used internally. Service types that start with an interrogation
 * mark "?" are optional, while the other ones are mandatory service dependencies.
 *
 * The injected service locators SHOULD NOT allow access to any other services not specified by the method.
 *
 * It is expected that ServiceSubscriber instances consume PSR-11-based service locators internally.
 * This interface does not dictate any injection method for these service locators, although constructor
 * injection is recommended.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
interface ServiceSubscriberInterface
{
    /**
     * Returns an array of service types required by such instances, optionally keyed by the service names used internally.
     *
     * For mandatory dependencies:
     *
     *  * ['logger' => 'MantiqVendors\Psr\Log\LoggerInterface'] means the objects use the "logger" name
     *    internally to fetch a service which must implement MantiqVendors\Psr\Log\LoggerInterface.
     *  * ['loggers' => 'MantiqVendors\Psr\Log\LoggerInterface[]'] means the objects use the "loggers" name
     *    internally to fetch an iterable of MantiqVendors\Psr\Log\LoggerInterface instances.
     *  * ['MantiqVendors\Psr\Log\LoggerInterface'] is a shortcut for
     *  * ['MantiqVendors\Psr\Log\LoggerInterface' => 'MantiqVendors\Psr\Log\LoggerInterface']
     *
     * otherwise:
     *
     *  * ['logger' => '?MantiqVendors\Psr\Log\LoggerInterface'] denotes an optional dependency
     *  * ['loggers' => '?MantiqVendors\Psr\Log\LoggerInterface[]'] denotes an optional iterable dependency
     *  * ['?MantiqVendors\Psr\Log\LoggerInterface'] is a shortcut for
     *  * ['MantiqVendors\Psr\Log\LoggerInterface' => '?MantiqVendors\Psr\Log\LoggerInterface']
     *
     * @return string[] The required service types, optionally keyed by service names
     */
    public static function getSubscribedServices();
}

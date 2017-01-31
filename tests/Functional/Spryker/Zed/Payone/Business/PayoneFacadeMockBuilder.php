<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Functional\Spryker\Zed\Payone\Business;

use PHPUnit_Framework_TestCase;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Payone\PayoneConfig;
use Spryker\Zed\Payone\PayoneDependencyProvider;
use Spryker\Zed\Payone\Persistence\PayoneQueryContainer;
use Spryker\Zed\Payone\Business\Api\Adapter\AdapterInterface;

class PayoneFacadeMockBuilder
{

    /**
     * @param \Spryker\Zed\Payone\Business\Api\Adapter\AdapterInterface $adapter
     * @param \PHPUnit_Framework_TestCase $testCase
     *
     * @return \Spryker\Zed\Ratepay\Business\RatepayFacade
     */
    public function build(AdapterInterface $adapter, PHPUnit_Framework_TestCase $testCase)
    {
        // Mock business factory to override return value of createExecutionAdapter to
        // place a mocked adapter that doesn't establish an actual connection.
        $businessFactoryMock = $this->getBusinessFactoryMock($adapter, $testCase);

        // Business factory always requires a valid query container. Since we're creating
        // functional/integration tests there's no need to mock the database layer.
        $queryContainer = new PayoneQueryContainer();
        $businessFactoryMock->setQueryContainer($queryContainer);

        $container = new Container();
        $payoneDependencyProvider = new PayoneDependencyProvider();
        $payoneDependencyProvider->provideBusinessLayerDependencies($container);

        $businessFactoryMock->setContainer($container);

        // Mock the facade to override getFactory() and have it return out
        // previously created mock.
        $facade = $testCase->getMock(
            'Spryker\Zed\Payone\Business\PayoneFacade',
            ['getFactory']
        );
        $facade->expects($testCase->any())
            ->method('getFactory')
            ->will($testCase->returnValue($businessFactoryMock));

        return $facade;
    }

    /**
     * @param \Spryker\Zed\Payone\Business\Api\Adapter\AdapterInterface $adapter
     * @param \PHPUnit_Framework_TestCase $testCase
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|\Spryker\Zed\Payone\Business\PayoneBusinessFactory
     */
    protected function getBusinessFactoryMock(AdapterInterface $adapter, PHPUnit_Framework_TestCase $testCase)
    {
        $businessFactoryMock = $testCase->getMock(
            'Spryker\Zed\Payone\Business\PayoneBusinessFactory',
            ['createExecutionAdapter'],
            []
        );

        $businessFactoryMock->setConfig(new PayoneConfig());
        $businessFactoryMock
            ->expects($testCase->any())
            ->method('createExecutionAdapter')
            ->will($testCase->returnValue($adapter));

        return $businessFactoryMock;
    }

}

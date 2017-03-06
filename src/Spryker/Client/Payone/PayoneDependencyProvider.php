<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\Payone;

use Spryker\Client\Kernel\AbstractDependencyProvider;
use Spryker\Client\Kernel\Container;

class PayoneDependencyProvider extends AbstractDependencyProvider
{

    const SERVICE_ZED = 'service zed';

    const SERVICE_UTIL_ENCODING = 'SERVICE_UTIL_ENCODING';

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    public function provideServiceLayerDependencies(Container $container)
    {
        $container[self::SERVICE_ZED] = function (Container $container) {
            return $container->getLocator()->zedRequest()->client();
        };

        $container[self::SERVICE_UTIL_ENCODING] = function (Container $container) {
            return $container->getLocator()->utilEncoding()->service();
        };

        return $container;
    }

}

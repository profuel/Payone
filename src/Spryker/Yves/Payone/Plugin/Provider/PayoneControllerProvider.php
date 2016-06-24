<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\Payone\Plugin\Provider;

use Silex\Application;
use Spryker\Yves\Application\Plugin\Provider\YvesControllerProvider;

class PayoneControllerProvider extends YvesControllerProvider
{

    /**
     * @param \Silex\Application $app
     * @return void
     */
    protected function defineControllers(Application $app)
    {
        $this->createController('/payone', 'payone', 'Payone', 'index');
    }

}

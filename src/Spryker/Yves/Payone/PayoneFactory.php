<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\Payone;

use Spryker\Yves\Kernel\AbstractFactory;
use Spryker\Yves\Payone\Form\DataProvider\PrePaymentDataProvider;
use Spryker\Yves\Payone\Form\PrePaymentForm;
use Spryker\Yves\Payone\Handler\PayoneHandler;
use Spryker\Yves\Payone\Plugin\PayonePrePaymentSubFormPlugin;

class PayoneFactory extends AbstractFactory
{

    /**
     * @return \Spryker\Yves\Payone\Form\PrePaymentForm
     */
    public function createPrePaymentForm()
    {
        return new PrePaymentForm();
    }

    /**
     * @return \Spryker\Yves\Payone\Form\DataProvider\PrePaymentDataProvider
     */
    public function createPrePaymentFormDataProvider()
    {
        return new PrePaymentDataProvider();
    }

    /**
     * @return \Spryker\Yves\Payone\Handler\PayoneHandler
     */
    public function createPayoneHandler()
    {
        return new PayoneHandler();
    }

    /**
     * @return \Spryker\Yves\Payone\Plugin\PayonePrePaymentSubFormPlugin
     */
    public function createPrePaymentSubFormPlugin()
    {
        return new PayonePrePaymentSubFormPlugin();
    }

}

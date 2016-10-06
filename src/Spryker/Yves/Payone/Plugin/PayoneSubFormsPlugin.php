<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\Payone\Plugin;

use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Shared\Kernel\Store;
use Spryker\Yves\Kernel\AbstractPlugin;

/**
 * @method \Spryker\Yves\Payone\PayoneFactory getFactory()
 */
class PayoneSubFormsPlugin extends AbstractPlugin
{

    /**
     * @var \Spryker\Yves\Payone\Plugin\PluginCountryFactory
     */
    protected $pluginCountryFactory;

    public function __construct()
    {
        $this->pluginCountryFactory = new PluginCountryFactory();
    }

    /**
     * @return \Spryker\Yves\StepEngine\Dependency\Plugin\Form\SubFormPluginInterface[]
     */
    public function getPaymentMethodsSubForms()
    {
        $subFormsCreator = $this->pluginCountryFactory->createSubFormsCreator(Store::getInstance()->getCurrentCountry());

        $paymentMethodsSubForms = $subFormsCreator->createPaymentMethodsSubForms();

        return $paymentMethodsSubForms;
    }

}

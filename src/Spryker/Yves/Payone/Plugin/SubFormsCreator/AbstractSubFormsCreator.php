<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\Payone\Plugin\SubFormsCreator;

use Spryker\Yves\Payone\Plugin\PayoneCreditCardSubFormPlugin;
use Spryker\Yves\Payone\Plugin\PayoneDirectDebitSubFormPlugin;
use Spryker\Yves\Payone\Plugin\PayoneEWalletSubFormPlugin;
use Spryker\Yves\Payone\Plugin\PayoneInstantOnlineTransferSubFormPlugin;
use Spryker\Yves\Payone\Plugin\PayoneInvoiceSubFormPlugin;
use Spryker\Yves\Payone\Plugin\PayonePrePaymentSubFormPlugin;

abstract class AbstractSubFormsCreator
{

    /**
     * @return \Spryker\Yves\Payone\Plugin\PayoneCreditCardSubFormPlugin
     */
    protected function createPayoneCreditCardSubFormPlugin()
    {
        return new PayoneCreditCardSubFormPlugin();
    }

    /**
     * @return \Spryker\Yves\Payone\Plugin\PayoneDirectDebitSubFormPlugin
     */
    protected function createPayoneDirectDebitSubFormPlugin()
    {
        return new PayoneDirectDebitSubFormPlugin();
    }

    /**
     * @return \Spryker\Yves\Payone\Plugin\PayonePrePaymentSubFormPlugin
     */
    protected function createPayonePrePaymentSubFormPlugin()
    {
        return new PayonePrePaymentSubFormPlugin();
    }

    /**
     * @return \Spryker\Yves\Payone\Plugin\PayoneInvoiceSubFormPlugin
     */
    protected function createPayoneInvoiceSubFormPlugin()
    {
        return new PayoneInvoiceSubFormPlugin();
    }

    /**
     * @return \Spryker\Yves\Payone\Plugin\PayoneEWalletSubFormPlugin
     */
    protected function createEWalletSubFormPlugin()
    {
        return new PayoneEWalletSubFormPlugin();
    }

    /**
     * @return \Spryker\Yves\Payone\Plugin\PayoneInstantOnlineTransferSubFormPlugin
     */
    protected function createPayoneInstantOnlineTransferSubFormPlugin()
    {
        return new PayoneInstantOnlineTransferSubFormPlugin();
    }

}

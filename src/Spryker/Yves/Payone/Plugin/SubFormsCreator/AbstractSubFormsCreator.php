<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\Payone\Plugin\SubFormsCreator;

use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Yves\Payone\Plugin\PayoneCreditCardSubFormPlugin;
use Spryker\Yves\Payone\Plugin\PayoneDirectDebitSubFormPlugin;
use Spryker\Yves\Payone\Plugin\PayoneEWalletSubFormPlugin;
use Spryker\Yves\Payone\Plugin\PayoneInvoiceSubFormPlugin;
use Spryker\Yves\Payone\Plugin\PayonePrePaymentSubFormPlugin;

abstract class AbstractSubFormsCreator
{

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer
     *
     * @return \Spryker\Yves\Payone\Plugin\PayoneCreditCardSubFormPlugin
     */
    protected function createPayoneCreditCardSubFormPlugin(QuoteTransfer $quoteTransfer)
    {
        return new PayoneCreditCardSubFormPlugin();
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Spryker\Yves\Payone\Plugin\PayoneDirectDebitSubFormPlugin
     */
    protected function createPayoneDirectDebitSubFormPlugin(QuoteTransfer $quoteTransfer)
    {
        return new PayoneDirectDebitSubFormPlugin();
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Spryker\Yves\Payone\Plugin\PayonePrePaymentSubFormPlugin
     */
    protected function createPayonePrePaymentSubFormPlugin(QuoteTransfer $quoteTransfer)
    {
        return new PayonePrePaymentSubFormPlugin();
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Spryker\Yves\Payone\Plugin\PayoneInvoiceSubFormPlugin
     */
    protected function createPayoneInvoiceSubFormPlugin(QuoteTransfer $quoteTransfer)
    {
        return new PayoneInvoiceSubFormPlugin();
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Spryker\Yves\Payone\Plugin\PayoneEWalletSubFormPlugin
     */
    protected function createEWalletSubFormPlugin(QuoteTransfer $quoteTransfer)
    {
        return new PayoneEWalletSubFormPlugin();
    }

}

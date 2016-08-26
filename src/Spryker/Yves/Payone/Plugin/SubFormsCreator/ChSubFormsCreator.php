<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\Payone\Plugin\SubFormsCreator;

use Generated\Shared\Transfer\PaymentTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Yves\Payone\Plugin\PayoneEpsOnlineTransferSubFormPlugin;
use Spryker\Yves\Payone\Plugin\PayonePostfinanceCardOnlineTransferSubFormPlugin;
use Spryker\Yves\Payone\Plugin\PayonePostfinanceEfinanceOnlineTransferSubFormPlugin;

class ChSubFormsCreator extends AbstractSubFormsCreator implements SubFormsCreatorInterface
{

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Spryker\Yves\StepEngine\Dependency\Plugin\Form\SubFormPluginInterface[]
     */
    public function createPaymentMethodsSubForms(QuoteTransfer $quoteTransfer)
    {
        return [
            PaymentTransfer::PAYONE_CREDIT_CARD => $this->createPayoneCreditCardSubFormPlugin($quoteTransfer),
            PaymentTransfer::PAYONE_DIRECT_DEBIT => $this->createPayoneDirectDebitSubFormPlugin($quoteTransfer),
            PaymentTransfer::PAYONE_PRE_PAYMENT => $this->createPayonePrePaymentSubFormPlugin($quoteTransfer),
            PaymentTransfer::PAYONE_INVOICE => $this->createPayoneInvoiceSubFormPlugin($quoteTransfer),
            PaymentTransfer::PAYONE_E_WALLET => $this->createEWalletSubFormPlugin($quoteTransfer),
            PaymentTransfer::PAYONE_POSTFINANCE_EFINANCE_ONLINE_TRANSFER => $this->createPayonePostfinanceEfinanceOnlineTransferSubFormPlugin($quoteTransfer),
            PaymentTransfer::PAYONE_POSTFINANCE_CARD_ONLINE_TRANSFER => $this->createPayonePostfinanceCardOnlineTransferSubFormPlugin($quoteTransfer),
        ];
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Spryker\Yves\Payone\Plugin\PayoneEpsOnlineTransferSubFormPlugin
     */
    protected function createPayoneEPSOnlineTransferSubFormPlugin(QuoteTransfer $quoteTransfer)
    {
        return new PayoneEpsOnlineTransferSubFormPlugin();
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Spryker\Yves\Payone\Plugin\PayonePostfinanceEfinanceOnlineTransferSubFormPlugin
     */
    protected function createPayonePostfinanceEfinanceOnlineTransferSubFormPlugin(QuoteTransfer $quoteTransfer)
    {
        return new PayonePostfinanceEfinanceOnlineTransferSubFormPlugin();
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Spryker\Yves\Payone\Plugin\PayonePostfinanceCardOnlineTransferSubFormPlugin
     */
    protected function createPayonePostfinanceCardOnlineTransferSubFormPlugin(QuoteTransfer $quoteTransfer)
    {
        return new PayonePostfinanceCardOnlineTransferSubFormPlugin();
    }

}

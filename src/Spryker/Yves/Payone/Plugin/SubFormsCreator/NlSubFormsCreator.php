<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\Payone\Plugin\SubFormsCreator;

use Generated\Shared\Transfer\PaymentTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Yves\Payone\Plugin\PayoneIdealOnlineTransferSubFormPlugin;

class NlSubFormsCreator extends AbstractSubFormsCreator implements SubFormsCreatorInterface
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
            PaymentTransfer::PAYONE_IDEAL_ONLINE_TRANSFER => $this->createPayoneIdealOnlineTransferSubFormPlugin($quoteTransfer),
            PaymentTransfer::PAYONE_INSTANT_ONLINE_TRANSFER => $this->createPayoneInstantOnlineTransferSubFormPlugin($quoteTransfer),
        ];
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Spryker\Yves\Payone\Plugin\PayoneIdealOnlineTransferSubFormPlugin
     */
    protected function createPayoneIdealOnlineTransferSubFormPlugin(QuoteTransfer $quoteTransfer)
    {
        return new PayoneIdealOnlineTransferSubFormPlugin();
    }

}

<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\Payone\Plugin\SubFormsCreator;

use Generated\Shared\Transfer\PaymentTransfer;
use Spryker\Yves\Payone\Plugin\PayoneGiropayOnlineTransferSubFormPlugin;

class DeSubFormsCreator extends AbstractSubFormsCreator implements SubFormsCreatorInterface
{

    /**
     * @return \Spryker\Yves\StepEngine\Dependency\Plugin\Form\SubFormPluginInterface[]
     */
    public function createPaymentMethodsSubForms()
    {
        return [
            PaymentTransfer::PAYONE_CREDIT_CARD => $this->createPayoneCreditCardSubFormPlugin(),
            PaymentTransfer::PAYONE_DIRECT_DEBIT => $this->createPayoneDirectDebitSubFormPlugin(),
            PaymentTransfer::PAYONE_PRE_PAYMENT => $this->createPayonePrePaymentSubFormPlugin(),
            PaymentTransfer::PAYONE_INVOICE => $this->createPayoneInvoiceSubFormPlugin(),
            PaymentTransfer::PAYONE_E_WALLET => $this->createEWalletSubFormPlugin(),
            PaymentTransfer::PAYONE_GIROPAY_ONLINE_TRANSFER => $this->createPayoneGiropayOnlineTransferSubFormPlugin(),
            PaymentTransfer::PAYONE_INSTANT_ONLINE_TRANSFER => $this->createPayoneInstantOnlineTransferSubFormPlugin(),
        ];
    }

    /**
     * @return \Spryker\Yves\Payone\Plugin\PayoneGiropayOnlineTransferSubFormPlugin
     */
    protected function createPayoneGiropayOnlineTransferSubFormPlugin()
    {
        return new PayoneGiropayOnlineTransferSubFormPlugin();
    }

}
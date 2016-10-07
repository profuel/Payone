<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\Payone\Plugin\SubFormsCreator;

use Generated\Shared\Transfer\PaymentTransfer;
use Spryker\Yves\Payone\Plugin\PayonePostfinanceCardOnlineTransferSubFormPlugin;
use Spryker\Yves\Payone\Plugin\PayonePostfinanceEfinanceOnlineTransferSubFormPlugin;

class ChSubFormsCreator extends AbstractSubFormsCreator implements SubFormsCreatorInterface
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
            PaymentTransfer::PAYONE_POSTFINANCE_EFINANCE_ONLINE_TRANSFER => $this->createPayonePostfinanceEfinanceOnlineTransferSubFormPlugin(),
            PaymentTransfer::PAYONE_POSTFINANCE_CARD_ONLINE_TRANSFER => $this->createPayonePostfinanceCardOnlineTransferSubFormPlugin(),
            PaymentTransfer::PAYONE_INSTANT_ONLINE_TRANSFER => $this->createPayoneInstantOnlineTransferSubFormPlugin(),
        ];
    }

    /**
     * @return \Spryker\Yves\Payone\Plugin\PayonePostfinanceEfinanceOnlineTransferSubFormPlugin
     */
    protected function createPayonePostfinanceEfinanceOnlineTransferSubFormPlugin()
    {
        return new PayonePostfinanceEfinanceOnlineTransferSubFormPlugin();
    }

    /**
     * @return \Spryker\Yves\Payone\Plugin\PayonePostfinanceCardOnlineTransferSubFormPlugin
     */
    protected function createPayonePostfinanceCardOnlineTransferSubFormPlugin()
    {
        return new PayonePostfinanceCardOnlineTransferSubFormPlugin();
    }

}

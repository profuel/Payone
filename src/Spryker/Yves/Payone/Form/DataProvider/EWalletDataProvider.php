<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\Payone\Form\DataProvider;

use Generated\Shared\Transfer\PaymentTransfer;
use Generated\Shared\Transfer\PayonePaymentTransfer;
use Spryker\Shared\Payone\PayoneApiConstants;
use Spryker\Shared\Transfer\AbstractTransfer;
use Spryker\Yves\Payone\Form\EWalletSubForm;
use Spryker\Yves\StepEngine\Dependency\Form\StepEngineFormDataProviderInterface;

class EWalletDataProvider implements StepEngineFormDataProviderInterface
{

    /**
     * @param \Spryker\Shared\Transfer\AbstractTransfer|\Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Spryker\Shared\Transfer\AbstractTransfer
     */
    public function getData(AbstractTransfer $quoteTransfer)
    {
        if ($quoteTransfer->getPayment() === null) {
            $paymentTransfer = new PaymentTransfer();
            $paymentTransfer->setPayone(new PayonePaymentTransfer());
            $paymentTransfer->setPayoneEWallet(new PayonePaymentTransfer());
            $quoteTransfer->setPayment($paymentTransfer);
        }
        return $quoteTransfer;
    }

    /**
     * @param \Spryker\Shared\Transfer\AbstractTransfer $quoteTransfer
     *
     * @return array
     */
    public function getOptions(AbstractTransfer $quoteTransfer)
    {
        return [
            EWalletSubForm::OPTION_WALLET_CHOICES => $this->getEWalletTypes(),
        ];
    }

    /**
     * @return array
     */
    protected function getEWalletTypes()
    {
        return [
            PayoneApiConstants::E_WALLET_TYPE_PAYPAL => 'PayPal',
            PayoneApiConstants::E_WALLET_TYPE_PAY_DIRECT => 'Paydirekt',
        ];
    }

}

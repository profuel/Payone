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
     * @param array $params
     *
     * @return \Spryker\Yves\StepEngine\Dependency\Plugin\Form\SubFormPluginInterface[]
     */
    public function createPaymentMethodsSubForms(QuoteTransfer $quoteTransfer, $params = [])
    {
        return [
            PaymentTransfer::PAYONE_CREDIT_CARD => $this->createPayoneCreditCardSubFormPlugin($quoteTransfer),
            PaymentTransfer::PAYONE_IDEAL_ONLINE_TRANSFER => $this->createPayoneIdealOnlineTransferSubFormPlugin($quoteTransfer),
        ];
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer
     *
     * @return \Spryker\Yves\Payone\Plugin\PayoneIdealOnlineTransferSubFormPlugin
     */
    protected function createPayoneIdealOnlineTransferSubFormPlugin(QuoteTransfer $quoteTransfer)
    {
        return new PayoneIdealOnlineTransferSubFormPlugin();
    }

}

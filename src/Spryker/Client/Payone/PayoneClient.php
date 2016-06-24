<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\Payone;

use Generated\Shared\Transfer\PayoneTransactionStatusUpdateTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @api
 *
 * @method \Spryker\Client\Payone\PayoneFactory getFactory()
 */
class PayoneClient extends AbstractClient implements PayoneClientInterface
{

    /**
     * @api
     *
     * @return \Spryker\Client\Payone\ClientApi\Request\CreditCardCheck
     */
    public function getCreditCardCheckRequest()
    {
        $defaults = [];
        return $this->getFactory()->createCreditCardCheckCall($defaults)->mapCreditCardCheckData();
    }

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\PayoneTransactionStatusUpdateTransfer $statusUpdateTransfer
     *
     * @return \Generated\Shared\Transfer\PayoneTransactionStatusUpdateTransfer
     */
    public function updateStatus(PayoneTransactionStatusUpdateTransfer $statusUpdateTransfer)
    {
        return $this->getFactory()->createZedStub()->updateStatus($statusUpdateTransfer);
    }

}

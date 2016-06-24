<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\Payone\Zed;

use Generated\Shared\Transfer\PayoneTransactionStatusUpdateTransfer;
use Spryker\Client\ZedRequest\Stub\BaseStub;

class PayoneStub extends BaseStub
{

    /**
     *
     * @return \Generated\Shared\Transfer\PayoneTransactionStatusUpdateTransfer
     */
    public function updateStatus(PayoneTransactionStatusUpdateTransfer $transactionStatus)
    {
        return $this->zedStub->call(
            '/payone/gateway/status-update',
            $transactionStatus
        );
    }

}

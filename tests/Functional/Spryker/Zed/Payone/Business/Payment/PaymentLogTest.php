<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Functional\Spryker\Zed\Payone\Business\Payment;

use Functional\Spryker\Zed\Payone\Business\AbstractPayoneTest;
use Generated\Shared\Transfer\OrderCollectionTransfer;
use Generated\Shared\Transfer\PaymentDetailTransfer;
use Generated\Shared\Transfer\PayonePaymentLogCollectionTransfer;
use Orm\Zed\Payone\Persistence\SpyPaymentPayoneDetail;
use Orm\Zed\Payone\Persistence\SpyPaymentPayoneDetailQuery;
use Spryker\Shared\Payone\PayoneApiConstants;

/**
 * @group Functional
 * @group Spryker
 * @group Zed
 * @group Payone
 * @group Business
 * @group Payment
 * @group PaymentLogTest
 */
class PaymentLogTest extends AbstractPayoneTest
{

    public function testGetPaymentLogs()
    {
        $apiLogs = [];
        $this->createPayonePayment();
        $apiLogs[] = $this->createPayoneApiLog(PayoneApiConstants::REQUEST_TYPE_REFUND, PayoneApiConstants::RESPONSE_TYPE_APPROVED);
        $apiLogs[] = $this->createPayoneApiLog(PayoneApiConstants::REQUEST_TYPE_AUTHORIZATION, PayoneApiConstants::RESPONSE_TYPE_REDIRECT);
        $apiLogs[] = $this->createPayoneApiLog(PayoneApiConstants::REQUEST_TYPE_CAPTURE, PayoneApiConstants::RESPONSE_TYPE_TIMEOUT);

        $orderCollection = (new OrderCollectionTransfer())
            ->addOrders($this->orderTransfer);
        $paymentLogCollectionTransfer = $this->payoneFacade->getPaymentLogs($orderCollection);

        $this->assertInstanceOf(PayonePaymentLogCollectionTransfer::class, $paymentLogCollectionTransfer);
        $this->assertEquals(count($apiLogs), $paymentLogCollectionTransfer->getPaymentLogs()->count());

        foreach ($paymentLogCollectionTransfer->getPaymentLogs() as $key => $paymentLog) {
            $this->assertEquals($apiLogs[$key]->getTransactionId(), $paymentLog->getTransactionId());
            $this->assertEquals($apiLogs[$key]->getStatus(), $paymentLog->getStatus());
            $this->assertEquals($apiLogs[$key]->getRequest(), $paymentLog->getRequest());
        }
    }

}
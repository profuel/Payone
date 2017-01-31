<?php
/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Functional\Spryker\Zed\Payone\Business;

use Orm\Zed\Payone\Persistence\SpyPaymentPayone;
use Orm\Zed\Payone\Persistence\SpyPaymentPayoneApiLog;
use Orm\Zed\Payone\Persistence\SpyPaymentPayoneDetail;
use Orm\Zed\Payone\Persistence\SpyPaymentPayoneTransactionStatusLog;
use Orm\Zed\Payone\Persistence\SpyPaymentPayoneTransactionStatusLogOrderItem;
use Spryker\Shared\Payone\PayoneApiConstants;

/**
 * @group Functional
 * @group Spryker
 * @group Zed
 * @group Ratepay
 * @group Business
 * @group Request
 * @group AbstractPayoneTest
 */
abstract class AbstractPayoneTest extends AbstractBusinessTest
{

    /**
     * @var SpyPaymentPayoneTransactionStatusLog
     */
    protected $spyPayoneTransactionStatusLog;

    protected function createPayonePayment($method = PayoneApiConstants::PAYMENT_METHOD_INVOICE)
    {
        $this->spyPaymentPayone = (new SpyPaymentPayone())
            ->setSpySalesOrder($this->orderEntity)
            ->setPaymentMethod($method)
            ->setReference('TX15887428dd2212')
            ->setTransactionId('213552995');
        $this->spyPaymentPayone->save();
    }

    protected function createPayoneApiLog(
        $request = PayoneApiConstants::REQUEST_TYPE_AUTHORIZATION,
        $status = PayoneApiConstants::RESPONSE_TYPE_APPROVED
    ) {
        $paymentApiLog = (new SpyPaymentPayoneApiLog())
            ->setRequest($request)
            ->setStatus($status)
            ->setMode(PayoneApiConstants::MODE_TEST)
            ->setTransactionId('213552995')
            ->setMerchantId('32481')
            ->setUserId('123')
            ->setPortalId('123')
            ->setSpyPaymentPayone($this->spyPaymentPayone);
        $paymentApiLog->save();
    }

    protected function createPayonePaymentDetail($iban = '', $bic = '')
    {
        $paymentApiLog = (new SpyPaymentPayoneDetail())
            ->setAmount(12345)
            ->setIban($iban)
            ->setBic($bic)
            ->setCurrency('EUR')
            ->setSpyPaymentPayone($this->spyPaymentPayone);
        $paymentApiLog->save();
    }

    protected function createPayoneTransactionStatusLog($status = PayoneApiConstants::RESPONSE_TYPE_APPROVED, $balance = 0)
    {
        $this->spyPayoneTransactionStatusLog = (new SpyPaymentPayoneTransactionStatusLog())
            ->setSpyPaymentPayone($this->spyPaymentPayone)
            ->setBalance($balance)
            ->setStatus($status)
            ->setMode(PayoneApiConstants::MODE_TEST);
        $this->spyPayoneTransactionStatusLog->save();
    }

    protected function createPayoneTransactionStatusLogItem($idOrderItem)
    {
        $transactionStatusLogOrderItem = (new SpyPaymentPayoneTransactionStatusLogOrderItem())
            ->setSpyPaymentPayoneTransactionStatusLog($this->spyPayoneTransactionStatusLog)
            ->setIdSalesOrderItem($idOrderItem);
        $transactionStatusLogOrderItem->save();
    }

}

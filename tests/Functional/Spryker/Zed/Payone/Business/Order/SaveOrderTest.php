<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Functional\Spryker\Zed\Payone\Business\Order;

use Functional\Spryker\Zed\Payone\Business\AbstractPayoneTest;
use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\PaymentDetailTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;
use Orm\Zed\Payone\Persistence\Base\SpyPaymentPayone;
use Orm\Zed\Payone\Persistence\Base\SpyPaymentPayoneQuery;
use Orm\Zed\Payone\Persistence\SpyPaymentPayoneDetail;
use Spryker\Shared\Payone\PayoneApiConstants;

/**
 * @group Functional
 * @group Spryker
 * @group Zed
 * @group Payone
 * @group Business
 * @group Order
 * @group SaveOrderTest
 */
class SaveOrderTest extends AbstractPayoneTest
{

    public function testSaveOrder()
    {
        $checkoutResponseTransfer = $this->hydrateCheckoutResponseTransfer();
        $this->preparePayonePaymentTransfer();

        $this->payoneFacade->saveOrder($this->quoteTransfer, $checkoutResponseTransfer);

        $payoneEntity = SpyPaymentPayoneQuery::create()
            ->filterByFkSalesOrder($this->orderEntity->getIdSalesOrder())
            ->findOne();
        $paymentDetailEntity = $payoneEntity->getSpyPaymentPayoneDetail();

        $this->assertInstanceOf(SpyPaymentPayone::class, $payoneEntity);
        $this->assertEquals(PayoneApiConstants::PAYMENT_METHOD_INVOICE, $payoneEntity->getPaymentMethod());
        $this->assertNotEmpty($payoneEntity->getReference());

        $this->assertInstanceOf(SpyPaymentPayoneDetail::class, $paymentDetailEntity);
        $this->assertEquals('EUR', $paymentDetailEntity->getCurrency());
        $this->assertEquals('iban', $paymentDetailEntity->getIban());
        $this->assertEquals('bic', $paymentDetailEntity->getBic());
        $this->assertEquals('12345', $paymentDetailEntity->getAmount());
    }

    /**
     * @return CheckoutResponseTransfer
     */
    protected function hydrateCheckoutResponseTransfer()
    {
        $checkoutResponseTransfer = (new CheckoutResponseTransfer())
            ->setSaveOrder(
                (new SaveOrderTransfer())
                    ->setIdSalesOrder($this->orderEntity->getIdSalesOrder())
            );

        return $checkoutResponseTransfer;
    }

    /**
     * @return void
     */
    protected function preparePayonePaymentTransfer()
    {
        $this->quoteTransfer->getPayment()
            ->getPayone()
            ->setPaymentMethod(PayoneApiConstants::PAYMENT_METHOD_INVOICE)
            ->setFkSalesOrder($this->orderEntity->getIdSalesOrder())
            ->setPaymentDetail(
                (new PaymentDetailTransfer())
                    ->setAmount(12345)
                    ->setIban('iban')
                    ->setBic('bic')
                    ->setCurrency('EUR')
            );
    }

}
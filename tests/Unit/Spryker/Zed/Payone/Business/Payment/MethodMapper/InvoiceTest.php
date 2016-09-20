<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Unit\Spryker\Zed\Payone\Business\Payment\MethodMapper;

use Spryker\Zed\Payone\Business\Payment\MethodMapper\Invoice;

/**
 * @group Unit
 * @group Spryker
 * @group Zed
 * @group Payone
 * @group Business
 * @group Payment
 * @group MethodMapper
 * @group InvoiceTest
 */
class InvoiceTest extends AbstractMethodMapperTest
{

    /**
     * @return void
     */
    public function testMapPaymentToCapture()
    {
        $paymentEntity = $this->getPaymentEntityMock();
        $paymentMethodMapper = $this->preparePaymentMethodMapper(new Invoice($this->getStoreConfigMock()));

        $requestData = $paymentMethodMapper->mapPaymentToCapture($paymentEntity);

        $this->assertSame(static::AMOUNT_FULL, $requestData->getAmount());
        $this->assertSame(static::STANDARD_PARAMETER_CURRENCY, $requestData->getCurrency());
        $this->assertSame(static::TRANSACTION_ID, $requestData->getTxid());
    }

}

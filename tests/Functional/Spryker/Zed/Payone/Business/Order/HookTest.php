<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Functional\Spryker\Zed\Payone\Business\Order;

use Functional\Spryker\Zed\Payone\Business\AbstractPayoneTest;
use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Spryker\Shared\Payone\PayoneApiConstants;

/**
 * @group Functional
 * @group Spryker
 * @group Zed
 * @group Payone
 * @group Business
 * @group Order
 * @group HookTest
 */
class HookTest extends AbstractPayoneTest
{

    public function testPostSaveHook()
    {
        $this->createPayonePayment();
        $this->createPayoneApiLog(PayoneApiConstants::REQUEST_TYPE_AUTHORIZATION, PayoneApiConstants::RESPONSE_TYPE_APPROVED);

        $checkoutResponseTransfer = new CheckoutResponseTransfer();
        $this->quoteTransfer->getPayment()
            ->getPayone()
            ->setFkSalesOrder($this->orderEntity->getIdSalesOrder());
        $newCheckoutResponseTransfer = $this->payoneFacade->postSaveHook($this->quoteTransfer, $checkoutResponseTransfer);

        $this->assertInstanceOf(CheckoutResponseTransfer::class, $newCheckoutResponseTransfer);
        $this->assertTrue($newCheckoutResponseTransfer->getIsExternalRedirect());
        $this->assertEquals('redirect url', $newCheckoutResponseTransfer->getRedirectUrl());
    }

}
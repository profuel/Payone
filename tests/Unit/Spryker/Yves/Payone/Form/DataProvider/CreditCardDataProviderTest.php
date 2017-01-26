<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Unit\Spryker\Yves\Payone\Form\DataProvider;

use Generated\Shared\Transfer\AddressTransfer;
use Generated\Shared\Transfer\PaymentTransfer;
use Generated\Shared\Transfer\PayonePaymentTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use PHPUnit_Framework_TestCase;
use Spryker\Yves\Payone\Form\DataProvider\CreditCardDataProvider;

/**
 * @group Unit
 * @group Spryker
 * @group Yves
 * @group Payone
 * @group Form
 * @group DataProvider
 * @group CreditCardDataProviderTest
 */
class CreditCardDataProviderTest extends PHPUnit_Framework_TestCase
{

    /**
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    protected function getQuoteTransfer()
    {
        $quoteTransfer = new QuoteTransfer();
        $billingAddress = new AddressTransfer();
        $quoteTransfer->setBillingAddress($billingAddress);

        return $quoteTransfer;
    }

    /**
     * @return void
     */
    public function testGetDataShouldAddTransferIfNotSet()
    {
        $creditCardDataProvider = new CreditCardDataProvider();
        $quoteTransfer = $this->getQuoteTransfer();

        $creditCardDataProvider->getData($quoteTransfer);

        $paymentTransfer = $quoteTransfer->getPayment();
        $this->assertInstanceOf(PaymentTransfer::class, $paymentTransfer);
        $this->assertInstanceOf(PayonePaymentTransfer::class, $paymentTransfer->getPayone());
    }

}

<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Unit\Spryker\Yves\Payone\Handler;

use Generated\Shared\Transfer\AddressTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\PaymentTransfer;
use Generated\Shared\Transfer\PayonePaymentTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\TotalsTransfer;
use Spryker\Yves\Payone\Handler\PayoneHandler;
use Symfony\Component\HttpFoundation\Request;

/**
 * @group Unit
 * @group Spryker
 * @group Yves
 * @group Payone
 * @group Handler
 * @group PayoneHandlerTest
 */
class PayoneHandlerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @return void
     */
    public function testAddPaymentToQuoteShouldReturnQuoteTransfer()
    {
        $paymentHandler = new PayoneHandler();

        $request = Request::createFromGlobals();
        $quoteTransfer = new QuoteTransfer();

        $billingAddress = new AddressTransfer();
        $billingAddress->setSalutation('Mr');
        $billingAddress->setIso2Code('iso2Code');
        $quoteTransfer->setBillingAddress($billingAddress);

        $customerTransfer = new CustomerTransfer();
        $customerTransfer->setEmail('test@spryker.com');
        $quoteTransfer->setCustomer($customerTransfer);

        $paymentTransfer = new PaymentTransfer();
        $paymentTransfer->setPaymentSelection('payoneInvoice');
        $payonePaymentTransfer = new PayonePaymentTransfer();
        $paymentTransfer->setPayoneInvoice($payonePaymentTransfer);
        $quoteTransfer->setPayment($paymentTransfer);

        $totalsTransfer = new TotalsTransfer();
        $totalsTransfer->setGrandTotal(100);
        $quoteTransfer->setTotals($totalsTransfer);

        $result = $paymentHandler->addPaymentToQuote($request, $quoteTransfer);
        $this->assertInstanceOf(QuoteTransfer::class, $result);
    }

}

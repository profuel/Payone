<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\Payone\Form\DataProvider;

use Generated\Shared\Transfer\PaymentTransfer;
use Generated\Shared\Transfer\PayonePaymentTransfer;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;
use Spryker\Yves\Payone\Form\CreditCardSubForm;
use Spryker\Yves\StepEngine\Dependency\Form\StepEngineFormDataProviderInterface;

class CreditCardDataProvider implements StepEngineFormDataProviderInterface
{

    /**
     * @param \Spryker\Shared\Kernel\Transfer\AbstractTransfer|\Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Spryker\Shared\Kernel\Transfer\AbstractTransfer
     */
    public function getData(AbstractTransfer $quoteTransfer)
    {
        if ($quoteTransfer->getPayment() === null) {
            $paymentTransfer = new PaymentTransfer();
            $paymentTransfer->setPayone(new PayonePaymentTransfer());
            $quoteTransfer->setPayment($paymentTransfer);
        }
        return $quoteTransfer;
    }

    /**
     * @param \Spryker\Shared\Kernel\Transfer\AbstractTransfer $quoteTransfer
     *
     * @return array
     */
    public function getOptions(AbstractTransfer $quoteTransfer)
    {
        return [
            CreditCardSubForm::OPTION_CARD_EXPIRES_CHOICES_MONTH => $this->getMonthChoices(),
            CreditCardSubForm::OPTION_CARD_EXPIRES_CHOICES_YEAR => $this->getYearChoices(),
            CreditCardSubForm::OPTION_CARD_TYPES => $this->getCardTypes(),
        ];
    }

    /**
     * @return array
     */
    protected function getMonthChoices()
    {
        return [
            '01' => '01',
            '02' => '02',
            '03' => '03',
            '04' => '04',
            '05' => '05',
            '06' => '06',
            '07' => '07',
            '08' => '08',
            '09' => '09',
            '10' => '10',
            '11' => '11',
            '12' => '12',
        ];
    }

    /**
     * @return array
     */
    protected function getYearChoices()
    {
        $currentYear = date('Y');

        return [
            $currentYear => $currentYear,
            ++$currentYear => $currentYear,
            ++$currentYear => $currentYear,
            ++$currentYear => $currentYear,
            ++$currentYear => $currentYear,
        ];
    }

    /**
     * @return array
     */
    protected function getCardTypes()
    {
        return [
            'V' => 'Visa',
            'M' => 'Master Card',
            'A' => 'American Express',
            'D' => 'Diners',
            'J' => 'JCB',
            'O' => 'Maestro International',
            'U' => 'Maestro UK',
            'C' => 'Discover',
            'B' => 'Carte Bleue',
        ];
    }

}

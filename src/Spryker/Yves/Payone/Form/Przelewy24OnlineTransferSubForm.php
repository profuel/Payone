<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\Payone\Form;

use Generated\Shared\Transfer\PaymentTransfer;
use Spryker\Shared\Payone\PayoneApiConstants;
use Symfony\Component\Form\FormBuilderInterface;

class Przelewy24OnlineTransferSubForm extends OnlineTransferSubForm
{

    const PAYMENT_METHOD = 'przelewy24_online_transfer';
    const OPTION_BANK_COUNTRIES = 'przelewy24 online transfer bank countries';

    /**
     * @return string
     */
    public function getPropertyPath()
    {
        return PaymentTransfer::PAYONE_PRZELEWY24_ONLINE_TRANSFER;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return \Spryker\Yves\Payone\Form\EPSOnlineTransferSubForm
     */
    public function addOnlineBankTransferType(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            static::FIELD_ONLINE_BANK_TRANSFER_TYPE,
            'hidden',
            [
                'label' => false,
                'data' => PayoneApiConstants::ONLINE_BANK_TRANSFER_TYPE_PRZELEWY24,
            ]
        );

        return $this;
    }

}

<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\Payone\Form;

use Generated\Shared\Transfer\PaymentTransfer;
use Spryker\Shared\Payone\PayoneApiConstants;
use Symfony\Component\Form\FormBuilderInterface;

class EPSOnlineTransferSubForm extends OnlineTransferSubForm
{

    const PAYMENT_METHOD = 'eps_online_transfer';
    const OPTION_BANK_COUNTRIES = 'eps online transfer bank countries';
    const OPTION_BANK_GROUP_TYPES = 'eps online transfer bank group types';

    /**
     * @return string
     */
    public function getPropertyPath()
    {
        return PaymentTransfer::PAYONE_EPS_ONLINE_TRANSFER;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $this->addBankGroupType($builder, $options);
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
                'data' => PayoneApiConstants::ONLINE_BANK_TRANSFER_TYPE_EPS_ONLINE_BANK_TRANSFER,
            ]
        );

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return \Spryker\Yves\Payone\Form\EPSOnlineTransferSubForm
     */
    protected function addBankGroupType(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            static::FIELD_BANK_GROUP_TYPE,
            'choice',
            [
                'label' => false,
                'required' => true,
                'expanded' => false,
                'multiple' => false,
                'empty_value' => false,
                'choices' => $options[static::OPTIONS_FIELD_NAME][static::OPTION_BANK_GROUP_TYPES],
                'constraints' => [],
            ]
        );

        return $this;
    }

}

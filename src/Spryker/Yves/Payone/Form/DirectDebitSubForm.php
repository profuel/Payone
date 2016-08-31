<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\Payone\Form;

use Generated\Shared\Transfer\PaymentTransfer;
use Generated\Shared\Transfer\PayonePaymentDirectDebitTransfer;
use Spryker\Shared\Payone\PayoneConstants;
use Spryker\Yves\Payone\Form\Constraint\ManageMandate;
use Spryker\Yves\StepEngine\Dependency\Form\SubFormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class DirectDebitSubForm extends AbstractPayoneSubForm
{

    const PAYMENT_METHOD = 'direct_debit';
    const FIELD_IBAN = 'iban';
    const FIELD_BIC = 'bic';

    /**
     * @var \Spryker\Client\Payone\PayoneClient
     */
    protected $payoneClient;

    /**
     * @return string
     */
    public function getName()
    {
        return PaymentTransfer::PAYONE_DIRECT_DEBIT;
    }

    /**
     * @return string
     */
    public function getPropertyPath()
    {
        return PaymentTransfer::PAYONE_DIRECT_DEBIT;
    }

    /**
     * @return string
     */
    public function getTemplatePath()
    {
        return PayoneConstants::PROVIDER_NAME . '/' . self::PAYMENT_METHOD;
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
     *
     * @return void
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setDefaults([
            'data_class' => PayonePaymentDirectDebitTransfer::class,
            SubFormInterface::OPTIONS_FIELD_NAME => [],
        ]);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->addIBAN($builder)
            ->addBIC($builder);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return \Spryker\Yves\Payone\Form\DirectDebitSubForm
     */
    protected function addIBAN(FormBuilderInterface $builder)
    {
        $builder->add(
            self::FIELD_IBAN,
            'text',
            [
                'label' => false,
                'required' => true,
                'constraints' => [
                    $this->createNotBlankConstraint(),
                ],
            ]
        );

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return \Spryker\Yves\Payone\Form\DirectDebitSubForm
     */
    protected function addBIC(FormBuilderInterface $builder)
    {
        $builder->add(
            self::FIELD_BIC,
            'text',
            [
                'label' => false,
                'required' => true,
                'constraints' => [
                    $this->createNotBlankConstraint(),
                    $this->createManageMandateConstraint(),
                ],
            ]
        );

        return $this;
    }

    /**
     * @return \Symfony\Component\Validator\Constraint
     */
    protected function createNotBlankConstraint()
    {
        return new NotBlank(['groups' => $this->getPropertyPath()]);
    }

    /**
     * @return \Symfony\Component\Validator\Constraint
     */
    protected function createManageMandateConstraint()
    {
        return new ManageMandate(['payoneClient' => $this->payoneClient]);
    }

}

<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\Payone\Form;

use Spryker\Client\Payone\PayoneClientInterface;
use Spryker\Shared\Payone\PayoneConstants;
use Spryker\Yves\StepEngine\Dependency\Form\AbstractSubFormType;
use Spryker\Yves\StepEngine\Dependency\Form\SubFormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

abstract class AbstractPayoneSubForm extends AbstractSubFormType implements SubFormInterface
{

    const PAYMENT_PROVIDER = PayoneConstants::PROVIDER_NAME;

    const FIELD_PRE_PAYMENT_METHOD = 'paymentMethod';
    const FIELD_PAYONE_CREDENTIALS_MID = 'payone_mid';
    const FIELD_PAYONE_CREDENTIALS_AID = 'payone_aid';
    const FIELD_PAYONE_CREDENTIALS_PORTAL_ID = 'payone_portal_id';
    const FIELD_PAYONE_HASH = 'payone_hash';
    const FIELD_CLIENT_API_CONFIG = 'payone_client_api_config';

    /**
     * @var \Spryker\Client\Payolution\PayolutionClientInterface
     */
    protected $payoneClient;

    /**
     * @param \Spryker\Client\Payone\PayoneClientInterface $payoneClient
     */
    public function __construct(PayoneClientInterface $payoneClient)
    {
        $this->payoneClient = $payoneClient;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addLabel(FormBuilderInterface $builder)
    {
        $builder->add(
            self::FIELD_PRE_PAYMENT_METHOD,
            'choice',
            [
                'label'    => false,
                'required' => true,
                'choices' => [
                    'prepayment' => 'Pre Payment'
                ]
            ]
        );

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addHiddenInputs(FormBuilderInterface $builder)
    {
        $formData = $this->payoneClient->getCreditCardCheckRequest();
        $builder->add(
            self::FIELD_CLIENT_API_CONFIG,
            'hidden',
            [
                'label' => false,
                'data' => $formData->toJson()
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

}

<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\Payone\Form;

use Spryker\Shared\Payone\PayoneConstants;
use Spryker\Yves\StepEngine\Dependency\Form\AbstractSubFormType;
use Spryker\Yves\StepEngine\Dependency\Form\SubFormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

abstract class AbstractPayoneSubForm extends AbstractSubFormType implements SubFormInterface
{

    const PAYMENT_PROVIDER = PayoneConstants::PROVIDER_NAME;
    const FIELD_PRE_PAYMENT_METHOD = 'paymentMethod';

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
     * @return \Symfony\Component\Validator\Constraint
     */
    protected function createNotBlankConstraint()
    {
        return new NotBlank(['groups' => $this->getPropertyPath()]);
    }

}

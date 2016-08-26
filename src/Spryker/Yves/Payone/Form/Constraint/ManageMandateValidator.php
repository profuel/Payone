<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\Payone\Form\Constraint;

use Generated\Shared\Transfer\QuoteTransfer;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ManageMandateValidator extends ConstraintValidator
{

    /**
     * @param string $value
     * @param \Symfony\Component\Validator\Constraint|\Spryker\Zed\Discount\Communication\Form\Constraint\QueryString $constraint
     *
     * @return void
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$value) {
            return;
        }

        /* @var $root Form */
        $root = $this->context->getRoot();

        /* @var $data \Generated\Shared\Transfer\QuoteTransfer */
        $data = $root->getData();

        $validationMessages = $this->manageMandate($data, $constraint);

        if (count($validationMessages) === 0) {
            return;
        }

        foreach ($validationMessages as $validationMessage) {
            $this->buildViolation($validationMessage)
                ->addViolation();
        }
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $data
     * @param \Spryker\Yves\Payone\Form\Constraint\ManageMandate $constraint
     *
     * @return array|string[]
     */
    protected function manageMandate(QuoteTransfer $data, ManageMandate $constraint)
    {
        $response = $constraint->getPayoneClient()->manageMandate($data);
        if ($response->getStatus() === PayoneApiConstants::RESPONSE_TYPE_ERROR) {
            return [$response->getCustomerErrorMessage()];
        }
        $data->getPayment()->getPayoneDirectDebit()->setMandateIdentification($response->getMandateIdentification());
        $data->getPayment()->getPayoneDirectDebit()->setMandateText(urldecode($response->getMandateText()));
        return [];
    }

}

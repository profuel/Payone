<?php
/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\Payone\Form\Constraint;

use Symfony\Component\Validator\Constraint as SymfonyConstraint;

class BankAccount extends SymfonyConstraint
{

    const OPTION_PAYONE_CLIENT = 'payoneClient';

    /**
     * @var \Spryker\Zed\Discount\Business\DiscountFacade
     */
    protected $payoneClient;

    /**
     * @return \Spryker\Zed\Discount\Business\DiscountFacade
     */
    public function getPayoneClient()
    {
        return $this->payoneClient;
    }

}

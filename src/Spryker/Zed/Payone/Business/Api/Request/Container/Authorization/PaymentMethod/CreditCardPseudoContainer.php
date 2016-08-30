<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Payone\Business\Api\Request\Container\Authorization\PaymentMethod;

use Spryker\Zed\Payone\Business\Api\Request\Container\Authorization\ThreeDSecureContainer;

class CreditCardPseudoContainer extends AbstractPaymentMethodContainer
{

    /**
     * @var string
     */
    protected $pseudocardpan;

    /**
     * @var \Spryker\Zed\Payone\Business\Api\Request\Container\Authorization\ThreeDSecureContainer
     */
    protected $threedsecure;

    /**
     * @param string $pseudoCardPan
     *
     * @return void
     */
    public function setPseudoCardPan($pseudoCardPan)
    {
        $this->pseudocardpan = $pseudoCardPan;
    }

    /**
     * @return string
     */
    public function getPseudoCardPan()
    {
        return $this->pseudocardpan;
    }

    /**
     * @param \Spryker\Zed\Payone\Business\Api\Request\Container\Authorization\ThreeDSecureContainer $threeDSecure
     *
     * @return void
     */
    public function setThreeDSecure(ThreeDSecureContainer $threeDSecure)
    {
        $this->threedsecure = $threeDSecure;
    }

    /**
     * @return \Spryker\Zed\Payone\Business\Api\Request\Container\Authorization\ThreeDSecureContainer
     */
    public function getThreeDSecure()
    {
        return $this->threedsecure;
    }

}

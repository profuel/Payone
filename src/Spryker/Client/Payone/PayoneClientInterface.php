<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\Payone;

interface PayoneClientInterface
{

    /**
     * @api
     *
     * @return \Spryker\Client\Payone\ClientApi\Request\CreditCardCheck
     */
    public function getCreditCardCheckRequest();

}

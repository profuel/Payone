<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Payone\Business\Api\Call;

interface CallInterface
{

    /**
     * @return void
     */
    public function setDoStoreCardData();

    /**
     * @return void
     */
    public function setDoNotStoreCardData();

    /**
     * @return \Spryker\Zed\Payone\Business\Api\Request\Container\CreditCardCheckContainer
     */
    public function mapCreditCardCheckData();

}

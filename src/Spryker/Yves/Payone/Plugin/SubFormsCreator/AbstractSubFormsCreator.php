<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\Payone\Plugin\SubFormsCreator;

use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Yves\Payone\Plugin\PayoneCreditCardSubFormPlugin;

abstract class AbstractSubFormsCreator
{

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer
     *
     * @return \Spryker\Yves\Payone\Plugin\PayoneCreditCardSubFormPlugin
     */
    protected function createPayoneCreditCardSubFormPlugin(QuoteTransfer $quoteTransfer)
    {
        return new PayoneCreditCardSubFormPlugin();
    }

}

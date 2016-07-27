<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\Payone\Plugin;

use Spryker\Yves\Kernel\AbstractPlugin;
use Spryker\Yves\StepEngine\Dependency\Plugin\Form\SubFormPluginInterface;

/**
 * @method \Spryker\Yves\Payone\PayoneFactory getFactory()
 */
class PayoneIdealOnlineTransferSubFormPlugin extends AbstractPlugin implements SubFormPluginInterface
{

    /**
     * @return \Spryker\Yves\Payone\Form\IdealOnlineTransferSubForm
     */
    public function createSubForm()
    {
        return $this->getFactory()->createIdealOnlineTransferSubForm();
    }

    /**
     * @return \Spryker\Yves\Payone\Form\DataProvider\IdealOnlineTransferDataProvider
     */
    public function createSubFormDataProvider()
    {
        return $this->getFactory()->createIdealOnlineTransferSubFormDataProvider();
    }

}

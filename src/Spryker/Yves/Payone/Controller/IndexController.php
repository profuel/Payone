<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\Payone\Controller;

use Generated\Shared\Transfer\PayoneTransactionStatusUpdateTransfer;
use Spryker\Yves\Application\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Spryker\Client\Payone\PayoneClientInterface getClient()
 * @method \Spryker\Yves\Payone\PayoneFactory getFactory()
 */
class IndexController extends AbstractController
{

    /**
     * @return array
     */
    public function indexAction(Request $request)
    {
        $statusUpdateTranfer = new PayoneTransactionStatusUpdateTransfer();
        $statusUpdateTranfer->fromArray($request->query->all(), true);

        return $this->jsonResponse(['response' => $this->getClient()->updateStatus($statusUpdateTranfer)]);
    }

}

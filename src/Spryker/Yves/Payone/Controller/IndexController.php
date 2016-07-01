<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\Payone\Controller;

use Generated\Shared\Transfer\PayoneTransactionStatusUpdateTransfer;
use Spryker\Yves\Application\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

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

        $response = $this->getClient()->updateStatus($statusUpdateTranfer)->getResponse();

        $callback = function () use ($response) {
            echo $response;
        };

        return $this->streamedResponse($callback);
    }

    /**
     * @param callable|null $callback
     * @param int $status
     * @param array $headers
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    protected function streamedResponse($callback = null, $status = 200, $headers = [])
    {
        $streamedResponse = new StreamedResponse($callback, $status, $headers);
        $streamedResponse->send();

        return $streamedResponse;
    }

}

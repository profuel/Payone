<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\Payone\Controller;

use Generated\Shared\Transfer\PayoneCancelRedirectTransfer;
use Generated\Shared\Transfer\PayoneGetFileTransfer;
use Generated\Shared\Transfer\PayoneGetInvoiceTransfer;
use Generated\Shared\Transfer\PayoneTransactionStatusUpdateTransfer;
use Pyz\Yves\Checkout\Plugin\Provider\CheckoutControllerProvider;
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
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
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
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function getfileAction(Request $request)
    {
        $getFileTransfer = new PayoneGetFileTransfer();
        $getFileTransfer->setReference($request->query->get('id'));

        $response = $this->getClient()->getFile($getFileTransfer);

        if ($response->getStatus() === 'ERROR') {
            return $this->viewResponse(['errormessage' => $response->getCustomerErrorMessage()]);
        }

        $callback = function () use ($response) {
            echo base64_decode($response->getRawResponse());
        };

        return $this->streamedResponse($callback, 200, ["Content-type" => "application/pdf"]);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function getInvoiceAction(Request $request)
    {
        $getInvoiceTransfer = new PayoneGetInvoiceTransfer();
        $getInvoiceTransfer->setReference($request->query->get('id'));

        $response = $this->getClient()->getInvoice($getInvoiceTransfer);

        if ($response->getStatus() === 'ERROR') {
            return $this->viewResponse(['errormessage' => $response->getInternalErrorMessage()]);
        }

        $callback = function () use ($response) {
            echo base64_decode($response->getRawResponse());
        };

        return $this->streamedResponse($callback, 200, ["Content-type" => "application/pdf"]);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function cancelRedirectAction(Request $request)
    {
        $orderReference = $request->query->get('orderReference');
        $urlHmac = $request->query->get('sig');

        if ($orderReference) {
            $cancelRedirectTransfer = new PayoneCancelRedirectTransfer();
            $cancelRedirectTransfer->setOrderReference($orderReference);
            $cancelRedirectTransfer->setUrlHmac($urlHmac);

            $response = $this->getClient()->cancelRedirect($cancelRedirectTransfer);
        }

        return $this->redirectResponseInternal(CheckoutControllerProvider::CHECKOUT_PAYMENT);
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

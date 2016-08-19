<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Payone\Business\ApiLog;

use Generated\Shared\Transfer\OrderTransfer;
use Orm\Zed\Payone\Persistence\SpyPaymentPayone;
use Spryker\Shared\Payone\PayoneApiConstants;
use Spryker\Zed\Payone\Persistence\PayoneQueryContainerInterface;

class ApiLogFinder
{

    /**
     * @var \Spryker\Zed\Payone\Persistence\PayoneQueryContainerInterface
     */
    private $queryContainer;

    /**
     * @param \Spryker\Zed\Payone\Persistence\PayoneQueryContainerInterface $queryContainer
     */
    public function __construct(PayoneQueryContainerInterface $queryContainer)
    {
        $this->queryContainer = $queryContainer;
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return bool
     */
    public function isPreAuthorizationApproved(OrderTransfer $orderTransfer)
    {
        return $this->hasApiLogStatus(
            $orderTransfer,
            PayoneApiConstants::REQUEST_TYPE_PREAUTHORIZATION,
            PayoneApiConstants::RESPONSE_TYPE_APPROVED
        );
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return bool
     */
    public function isPreAuthorizationRedirect(OrderTransfer $orderTransfer)
    {
        return $this->hasApiLogStatus(
            $orderTransfer,
            PayoneApiConstants::REQUEST_TYPE_PREAUTHORIZATION,
            PayoneApiConstants::RESPONSE_TYPE_REDIRECT
        );
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return bool
     */
    public function isPreAuthorizationError(OrderTransfer $orderTransfer)
    {
        return $this->hasApiLogStatus(
            $orderTransfer,
            PayoneApiConstants::REQUEST_TYPE_PREAUTHORIZATION,
            PayoneApiConstants::RESPONSE_TYPE_ERROR
        ) || $this->hasApiLogStatus(
            $orderTransfer,
            PayoneApiConstants::REQUEST_TYPE_PREAUTHORIZATION,
            PayoneApiConstants::RESPONSE_TYPE_TIMEOUT
        );
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return bool
     */
    public function isAuthorizationApproved(OrderTransfer $orderTransfer)
    {
        return $this->hasApiLogStatus(
            $orderTransfer,
            PayoneApiConstants::REQUEST_TYPE_AUTHORIZATION,
            PayoneApiConstants::RESPONSE_TYPE_APPROVED
        );
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return bool
     */
    public function isAuthorizationRedirect(OrderTransfer $orderTransfer)
    {
        return $this->hasApiLogStatus(
            $orderTransfer,
            PayoneApiConstants::REQUEST_TYPE_AUTHORIZATION,
            PayoneApiConstants::RESPONSE_TYPE_REDIRECT
        );
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return bool
     */
    public function isAuthorizationError(OrderTransfer $orderTransfer)
    {
        return $this->hasApiLogStatus(
            $orderTransfer,
            PayoneApiConstants::REQUEST_TYPE_AUTHORIZATION,
            PayoneApiConstants::RESPONSE_TYPE_ERROR
        );
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return bool
     */
    public function isCaptureApproved(OrderTransfer $orderTransfer)
    {
        return $this->hasApiLogStatus(
            $orderTransfer,
            PayoneApiConstants::REQUEST_TYPE_CAPTURE,
            PayoneApiConstants::RESPONSE_TYPE_APPROVED
        );
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return bool
     */
    public function isCaptureError(OrderTransfer $orderTransfer)
    {
        return $this->hasApiLogStatus(
            $orderTransfer,
            PayoneApiConstants::REQUEST_TYPE_CAPTURE,
            PayoneApiConstants::RESPONSE_TYPE_ERROR
        );
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return bool
     */
    public function isRefundApproved(OrderTransfer $orderTransfer)
    {
        return $this->hasApiLogStatus(
            $orderTransfer,
            PayoneApiConstants::REQUEST_TYPE_REFUND,
            PayoneApiConstants::RESPONSE_TYPE_APPROVED
        );
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return bool
     */
    public function isRefundError(OrderTransfer $orderTransfer)
    {
        return $this->hasApiLogStatus(
            $orderTransfer,
            PayoneApiConstants::REQUEST_TYPE_REFUND,
            PayoneApiConstants::RESPONSE_TYPE_ERROR
        );
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param string $request Relevant request
     * @param string $status Expected status
     *
     * @return bool
     */
    protected function hasApiLogStatus(OrderTransfer $orderTransfer, $request, $status)
    {
        $idSalesOrder = $orderTransfer->getIdSalesOrder();
        $apiLog = $this->queryContainer->createApiLogsByOrderIdAndRequest($idSalesOrder, $request)->filterByStatus($status)->findOne();

        if ($apiLog === null) {
            return false;
        }

        return $apiLog->getStatus() === $status;
    }

    /**
     * @param int $transactionId
     *
     * @return \Orm\Zed\Payone\Persistence\SpyPaymentPayone
     */
    protected function findPaymentByTransactionId($transactionId)
    {
        return $this->queryContainer->createPaymentByTransactionIdQuery($transactionId)->findOne();
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Orm\Zed\Payone\Persistence\SpyPaymentPayone
     */
    protected function findPaymentByOrder(OrderTransfer $orderTransfer)
    {
        return $this->queryContainer->createPaymentByOrderId($orderTransfer->getIdSalesOrder())->findOne();
    }

    /**
     * @param \Orm\Zed\Payone\Persistence\SpyPaymentPayone $payment
     * @param string $authorizationType
     *
     * @return \Orm\Zed\Payone\Persistence\SpyPaymentPayoneApiLog
     */
    protected function findApiLog(SpyPaymentPayone $payment, $authorizationType)
    {
        return $this->queryContainer->createApiLogByPaymentAndRequestTypeQuery(
            $payment->getPrimaryKey(),
            $authorizationType
        )->findOne();
    }

}

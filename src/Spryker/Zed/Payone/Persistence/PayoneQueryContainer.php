<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Payone\Persistence;

use Propel\Runtime\ActiveQuery\Criteria;
use Spryker\Zed\Kernel\Persistence\AbstractQueryContainer;

/**
 * @method \Spryker\Zed\Payone\Persistence\PayonePersistenceFactory getFactory()
 */
class PayoneQueryContainer extends AbstractQueryContainer implements PayoneQueryContainerInterface
{

    /**
     * @api
     *
     * @param int $transactionId
     *
     * @return \Orm\Zed\Payone\Persistence\SpyPaymentPayoneTransactionStatusLogQuery
     */
    public function createCurrentSequenceNumberQuery($transactionId)
    {
        $query = $this->getFactory()->createPaymentPayoneApiLogQuery();
        $query->filterByTransactionId($transactionId)
              ->orderBySequenceNumber(Criteria::DESC);

        return $query;
    }

    /**
     * @api
     *
     * @param int $transactionId
     *
     * @return \Orm\Zed\Payone\Persistence\Base\SpyPaymentPayoneQuery
     */
    public function createPaymentByTransactionIdQuery($transactionId)
    {
        $query = $this->getFactory()->createPaymentPayoneQuery();
        $query->filterByTransactionId($transactionId);

        return $query;
    }

    /**
     * @api
     *
     * @param int $fkPayment
     * @param string $requestName
     *
     * @return \Orm\Zed\Payone\Persistence\SpyPaymentPayoneApiLogQuery
     */
    public function createApiLogByPaymentAndRequestTypeQuery($fkPayment, $requestName)
    {
        $query = $this->getFactory()->createPaymentPayoneApiLogQuery();
        $query->filterByFkPaymentPayone($fkPayment)
              ->filterByRequest($requestName);

        return $query;
    }

    /**
     * @api
     *
     * @param int $idOrder
     *
     * @return \Orm\Zed\Payone\Persistence\Base\SpyPaymentPayoneQuery
     */
    public function createPaymentByOrderId($idOrder)
    {
        $query = $this->getFactory()->createPaymentPayoneQuery();
        $query->findByFkSalesOrder($idOrder);

        return $query;
    }

    /**
     * @api
     *
     * @param int $idOrder
     * @param string $request
     *
     * @return \Orm\Zed\Payone\Persistence\SpyPaymentPayoneApiLogQuery
     */
    public function createApiLogsByOrderIdAndRequest($idOrder, $request)
    {
        $query = $this->getFactory()->createPaymentPayoneApiLogQuery()
            ->useSpyPaymentPayoneQuery()
            ->filterByFkSalesOrder($idOrder)
            ->endUse()
            ->filterByRequest($request)
            ->orderByCreatedAt(Criteria::DESC) //TODO: Index?
            ->orderByIdPaymentPayoneApiLog(Criteria::DESC);

        return $query;
    }

    /**
     * @api
     *
     * @param int $paymentId
     *
     * @return \Orm\Zed\Payone\Persistence\Base\SpyPaymentPayoneQuery
     */
    public function createPaymentById($paymentId)
    {
        $query = $this->getFactory()->createPaymentPayoneQuery();
        $query->findByFkSalesOrder($paymentId);

        return $query;
    }

    /**
     * @api
     *
     * @param int $idIdSalesOrder
     *
     * @return \Orm\Zed\Payone\Persistence\SpyPaymentPayoneTransactionStatusLog[]
     */
    public function createTransactionStatusLogsBySalesOrder($idIdSalesOrder)
    {
        $query = $this->getFactory()->createPaymentPayoneTransactionStatusLogQuery()
            ->useSpyPaymentPayoneQuery()
            ->filterByFkSalesOrder($idIdSalesOrder)
            ->endUse()
            ->orderByCreatedAt();

        return $query;
    }

    /**
     * @api
     *
     * @param int $idSalesOrderItem
     * @param array $ids
     *
     * @return \Orm\Zed\Payone\Persistence\SpyPaymentPayoneTransactionStatusLogOrderItem[]
     */
    public function createTransactionStatusLogOrderItemsByLogIds($idSalesOrderItem, $ids)
    {
        $relations = $this->getFactory()->createPaymentPayoneTransactionStatusLogOrderItemQuery()
            ->filterByIdPaymentPayoneTransactionStatusLog($ids)
            ->filterByIdSalesOrderItem($idSalesOrderItem);

        return $relations;
    }

    /**
     * @api
     *
     * @param int $idSalesOrder
     *
     * @return \Orm\Zed\Payone\Persistence\SpyPaymentPayoneApiLogQuery
     */
    public function createLastApiLogsByOrderId($idSalesOrder)
    {
        $query = $this->getFactory()->createPaymentPayoneApiLogQuery()
            ->useSpyPaymentPayoneQuery()
            ->filterByFkSalesOrder($idSalesOrder)
            ->endUse()
            ->orderByCreatedAt(Criteria::DESC)
            ->orderByIdPaymentPayoneApiLog(Criteria::DESC);

        return $query;
    }

    /**
     * @api
     *
     * @param \Propel\Runtime\Collection\ObjectCollection $orders
     *
     * @return \Orm\Zed\Payone\Persistence\SpyPaymentPayoneApiLogQuery
     */
    public function createApiLogsByOrderIds($orders)
    {
        $ids = [];
        /** @var \Orm\Zed\Sales\Persistence\SpySalesOrder $order */
        foreach ($orders as $order) {
            $ids[] = $order->getIdSalesOrder();
        }

        $query = $this->getFactory()->createPaymentPayoneApiLogQuery()
            ->useSpyPaymentPayoneQuery()
            ->filterByFkSalesOrder($ids)
            ->endUse()
            ->orderByCreatedAt();

        return $query;
    }

    /**
     * @api
     *
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder[] $orders
     *
     * @return \Orm\Zed\Payone\Persistence\SpyPaymentPayoneTransactionStatusLogQuery
     */
    public function createTransactionStatusLogsByOrderIds($orders)
    {
        $ids = [];
        foreach ($orders as $order) {
            $ids[] = $order->getIdSalesOrder();
        }

        $query = $this->getFactory()->createPaymentPayoneTransactionStatusLogQuery()
            ->useSpyPaymentPayoneQuery()
            ->filterByFkSalesOrder($ids)
            ->endUse()
            ->orderByCreatedAt();

        return $query;
    }

}

<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Payone\Communication\Plugin\Oms\Command;

use Orm\Zed\Sales\Persistence\Base\SpySalesOrder;
use Orm\Zed\Sales\Persistence\Base\SpySalesOrderItem;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \Spryker\Zed\Payone\Communication\PayoneCommunicationFactory getFactory()
 * @method \Spryker\Zed\Payone\Business\PayoneFacade getFacade()
 */
class AbstractPayonePlugin extends AbstractPlugin
{

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $orderEntity
     *
     * @return \Generated\Shared\Transfer\ItemTransfer
     */
    protected function getItemTransfer(SpySalesOrderItem $orderItemEntity)
    {
        return $this
            ->getFactory()
            ->getSalesAggregatorFacade()
            ->getOrderItemTotalsByIdSalesOrderItem($orderItemEntity->getIdSalesOrderItem());
    }

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $orderEntity
     *
     * @return \Generated\Shared\Transfer\OrderTransfer
     */
    protected function getOrderTransfer(SpySalesOrder $orderEntity)
    {
        return $this
            ->getFactory()
            ->getSalesAggregatorFacade()
            ->getOrderTotalsByIdSalesOrder($orderEntity->getIdSalesOrder());
    }

}
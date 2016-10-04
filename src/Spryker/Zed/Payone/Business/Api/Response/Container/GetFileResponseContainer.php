<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Payone\Business\Api\Response\Container;

class GetFileResponseContainer extends AbstractResponseContainer
{

    /**
     * @var string
     */
    protected $DATA;

    /**
     * @return string
     */
    public function getDATA()
    {
        return $this->DATA;
    }

    /**
     * @param string $DATA
     *
     * @return void
     */
    public function setDATA($DATA)
    {
        $this->DATA = $DATA;
    }

}

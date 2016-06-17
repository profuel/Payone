<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\Payone\ClientApi\Request;

interface ContainerInterface
{

    /**
     * @return array
     */
    public function toArray();

    /**
     * @return string
     */
    public function __toString();

    /**
     * @return string
     */
    public function toJson();

}

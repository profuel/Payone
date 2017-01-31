<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Functional\Spryker\Zed\Payone\Business\Api\Adapter;

use Spryker\Zed\Payone\Business\Api\Adapter\AdapterInterface;
use Spryker\Zed\Payone\Business\Api\Adapter\Http\AbstractHttpAdapter;

class DummyAdapter extends AbstractHttpAdapter implements AdapterInterface
{

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct('');

        $this->rawResponse = $response;
    }

    /**
     * @param array $params
     *
     * @throws \Spryker\Zed\Payone\Business\Exception\TimeoutException
     *
     * @return array
     */
    protected function performRequest(array $params)
    {
        return $params;
    }

    /**
     * @param array $responseRaw
     *
     * @return array
     */
    protected function parseResponse(array $responseRaw = [])
    {
        return $responseRaw;
    }

}

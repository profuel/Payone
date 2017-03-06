<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\Payone\ClientApi\Request;

use Spryker\Service\UtilEncoding\UtilEncodingService;

abstract class AbstractContainer implements ContainerInterface
{

    /**
     * @var \Spryker\Service\UtilEncoding\UtilEncodingService
     */
    protected $utilEncodingService;

    /**
     * AbstractContainer constructor.
     * @param UtilEncodingService $utilEncodingService
     */
    public function __construct(UtilEncodingService $utilEncodingService)
    {
        $this->utilEncodingService = $utilEncodingService;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $result = [];
        foreach ($this as $key => $value) {
            if ($value === null) {
                continue;
            }
            if ($value instanceof ContainerInterface) {
                $result = array_merge($result, $value->toArray());
            } else {
                $result[$key] = $value;
            }
        }
        ksort($result);

        return $result;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $stringArray = [];
        foreach ($this->toArray() as $key => $value) {
            $stringArray[] = $key . '=' . $value;
        }
        $result = implode('|', $stringArray);

        return $result;
    }

    /**
     * @return string
     */
    public function toJson()
    {
        return $this->utilEncodingService->encodeJson($this->toArray());
    }

}

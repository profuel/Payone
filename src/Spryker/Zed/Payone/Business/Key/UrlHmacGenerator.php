<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Payone\Business\Key;

class UrlHmacGenerator
{

    /**
     * string
     */
    const HASH_ALGO = 'sha256';

    /**
     * @param string $string
     *
     * @return string
     */
    public function hash($string, $key)
    {
        return hash_hmac(static::HASH_ALGO, $string, $key);
    }

}

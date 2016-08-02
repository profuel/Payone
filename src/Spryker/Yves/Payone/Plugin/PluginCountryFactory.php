<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\Payone\Plugin;

use Spryker\Shared\Payone\PayoneConstants;
use Spryker\Yves\Kernel\AbstractPlugin;
use Spryker\Yves\Payone\Plugin\SubFormsCreator\AtSubFormsCreator;
use Spryker\Yves\Payone\Plugin\SubFormsCreator\ChSubFormsCreator;
use Spryker\Yves\Payone\Plugin\SubFormsCreator\DefaultSubFormsCreator;
use Spryker\Yves\Payone\Plugin\SubFormsCreator\DeSubFormsCreator;
use Spryker\Yves\Payone\Plugin\SubFormsCreator\NlSubFormsCreator;

/**
 * @method \Spryker\Yves\Payone\PayoneFactory getFactory()
 */
class PluginCountryFactory extends AbstractPlugin
{

    const DEFAULT_COUNTRY = 'default';

    /**
     * @var \Spryker\Yves\Payone\Plugin\SubFormsCreator\SubFormsCreatorInterface[]
     */
    protected $subFormsCreators = [];

    public function __construct()
    {
        $this->subFormsCreators = [
            PayoneConstants::COUNTRY_AT => function () {
                return new AtSubFormsCreator();
            },
            PayoneConstants::COUNTRY_NL => function () {
                return new NlSubFormsCreator();
            },
            PayoneConstants::COUNTRY_DE => function () {
                return new DeSubFormsCreator();
            },
            PayoneConstants::COUNTRY_CH => function () {
                return new ChSubFormsCreator();
            },
            self::DEFAULT_COUNTRY => function () {
                return new DefaultSubFormsCreator($this->getFactory()->getPayoneClient());
            },
        ];
    }

    /**
     * @param string $countryIso2Code
     *
     * @return \Spryker\Yves\Payone\Plugin\SubFormsCreator\SubFormsCreatorInterface
     */
    public function createSubFormsCreator($countryIso2Code)
    {
        if (isset($this->subFormsCreators[$countryIso2Code])) {
            $subFormsCreator = $this->subFormsCreators[$countryIso2Code]();
        } else {
            $subFormsCreator = $this->subFormsCreators[self::DEFAULT_COUNTRY]();
        }

        return $subFormsCreator;
    }

}

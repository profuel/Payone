<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\Payone;

use Generated\Shared\Transfer\PayoneStandardParameterTransfer;
use Spryker\Client\Kernel\AbstractFactory;
use Spryker\Client\Payone\ClientApi\Call\CreditCardCheck;
use Spryker\Client\Payone\ClientApi\HashGenerator;
use Spryker\Client\Payone\ClientApi\HashProvider;
use Spryker\Client\Payone\Zed\PayoneStub;
use Spryker\Shared\Config;
use Spryker\Shared\Payone\PayoneApiConstants;
use Spryker\Shared\Payone\PayoneConstants;
use Spryker\Zed\Payone\Business\Mode\ModeDetector;
use Spryker\Zed\Payone\PayoneConfig;

class PayoneFactory extends AbstractFactory
{

    /**
     * @param array $defaults
     *
     * @return \Spryker\Client\Payone\ClientApi\Call\CreditCardCheck
     */
    public function createCreditCardCheckCall(array $defaults)
    {
        return new CreditCardCheck(
            $this->createStandardParameter($defaults),
            $this->createHashGenerator(),
            $this->createModeDetector()
        );
    }

    /**
     * @return \Spryker\Shared\Payone\Dependency\HashInterface
     */
    protected function createHashProvider()
    {
        return new HashProvider();
    }

    /**
     * @return \Spryker\Shared\Payone\Dependency\ModeDetectorInterface
     */
    protected function createModeDetector()
    {
        return new ModeDetector($this->createBundleConfig());
    }

    /**
     * @return \Spryker\Zed\Payone\PayoneConfig
     */
    protected function createBundleConfig()
    {
        return new PayoneConfig();
    }

    /**
     * @return \Spryker\Client\Payone\ClientApi\HashGeneratorInterface
     */
    protected function createHashGenerator()
    {
        return new HashGenerator(
            $this->createHashProvider()
        );
    }

    /**
     * @param array $defaults
     *
     * @return \Generated\Shared\Transfer\PayoneStandardParameterTransfer
     */
    protected function createStandardParameter(array $defaults)
    {
        $standardParameterTransfer = new PayoneStandardParameterTransfer();
        $standardParameterTransfer->fromArray($defaults);

        $payoneConfig = Config::get(PayoneConstants::PAYONE);
        $standardParameterTransfer->setAid($payoneConfig[PayoneConstants::PAYONE_CREDENTIALS_AID]);
        $standardParameterTransfer->setMid($payoneConfig[PayoneConstants::PAYONE_CREDENTIALS_MID]);
        $standardParameterTransfer->setPortalId($payoneConfig[PayoneConstants::PAYONE_CREDENTIALS_PORTAL_ID]);
        $standardParameterTransfer->setKey($payoneConfig[PayoneConstants::PAYONE_CREDENTIALS_KEY]);
        $standardParameterTransfer->setEncoding($payoneConfig[PayoneConstants::PAYONE_CREDENTIALS_ENCODING]);
        $standardParameterTransfer->setResponseType(PayoneApiConstants::RESPONSE_TYPE_JSON);

        return $standardParameterTransfer;
    }

    /**
     * @return \Spryker\Client\Payone\Zed\PayoneStub
     */
    public function createZedStub()
    {
        $zedStub = $this->getProvidedDependency(PayoneDependencyProvider::SERVICE_ZED);
        return new PayoneStub($zedStub);
    }

}

<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Payone\Business\Payment\MethodMapper;

use Generated\Shared\Transfer\PayoneStandardParameterTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrderAddress;
use Spryker\Shared\Kernel\Store;
use Spryker\Zed\Payone\Business\Api\Request\Container\Authorization\PersonalContainer;
use Spryker\Zed\Payone\Business\Api\Request\Container\Authorization\RedirectContainer;
use Spryker\Zed\Payone\Business\Api\Request\Container\Authorization\ShippingContainer;
use Spryker\Zed\Payone\Business\Key\UrlHmacGenerator;
use Spryker\Zed\Payone\Business\Payment\PaymentMethodMapperInterface;
use Spryker\Zed\Payone\Business\SequenceNumber\SequenceNumberProviderInterface;

abstract class AbstractMapper implements PaymentMethodMapperInterface
{

    /**
     * @var \Generated\Shared\Transfer\PayoneStandardParameterTransfer
     */
    private $standardParameter;

    /**
     * @var \Spryker\Zed\Payone\Business\SequenceNumber\SequenceNumberProviderInterface
     */
    private $sequenceNumberProvider;

    /**
     * @var \Spryker\Zed\Payone\Business\Key\UrlHmacGenerator
     */
    private $urlHmacGenerator;

    /**
     * @var \Spryker\Shared\Kernel\Store
     */
    protected $storeConfig;

    /**
     * @param \Spryker\Shared\Kernel\Store $storeConfig
     */
    public function __construct(Store $storeConfig)
    {
        $this->storeConfig = $storeConfig;
    }

    /**
     * @param \Generated\Shared\Transfer\PayoneStandardParameterTransfer $standardParameterTransfer
     *
     * @return void
     */
    public function setStandardParameter(PayoneStandardParameterTransfer $standardParameterTransfer)
    {
        $this->standardParameter = $standardParameterTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\PayoneStandardParameterTransfer
     */
    protected function getStandardParameter()
    {
        return $this->standardParameter;
    }

    /**
     * @param \Spryker\Zed\Payone\Business\Key\UrlHmacGenerator $urlHmacGenerator
     *
     * @return void
     */
    public function setUrlHmacGenerator(UrlHmacGenerator $urlHmacGenerator)
    {
        $this->urlHmacGenerator = $urlHmacGenerator;
    }

    /**
     * @return \Spryker\Zed\Payone\Business\Key\UrlHmacGenerator
     */
    protected function getUrlHmacGenerator()
    {
        return $this->urlHmacGenerator;
    }

    /**
     * @param \Spryker\Zed\Payone\Business\SequenceNumber\SequenceNumberProviderInterface $sequenceNumberProvider
     *
     * @return void
     */
    public function setSequenceNumberProvider(SequenceNumberProviderInterface $sequenceNumberProvider)
    {
        $this->sequenceNumberProvider = $sequenceNumberProvider;
    }

    /**
     * @return \Spryker\Zed\Payone\Business\SequenceNumber\SequenceNumberProviderInterface
     */
    protected function getSequenceNumberProvider()
    {
        return $this->sequenceNumberProvider;
    }

    /**
     * @param string $transactionId
     *
     * @return int
     */
    protected function getNextSequenceNumber($transactionId)
    {
        $nextSequenceNumber = $this->getSequenceNumberProvider()->getNextSequenceNumber($transactionId);

        return $nextSequenceNumber;
    }

    /**
     * @param string $orderReference
     *
     * @return \Spryker\Zed\Payone\Business\Api\Request\Container\Authorization\RedirectContainer
     */
    protected function createRedirectContainer($orderReference)
    {
        $redirectContainer = new RedirectContainer();

        $sig = $this->getUrlHmacGenerator()->hash($orderReference, $this->getStandardParameter()->getKey());
        $params = '?orderReference=' . $orderReference . '&sig=' . $sig;

        $redirectContainer->setSuccessUrl($this->getStandardParameter()->getRedirectSuccessUrl() . $params);
        $redirectContainer->setBackUrl($this->getStandardParameter()->getRedirectBackUrl() . $params);
        $redirectContainer->setErrorUrl($this->getStandardParameter()->getRedirectErrorUrl() . $params);

        return $redirectContainer;
    }

    /**
     * @param \Spryker\Zed\Payone\Business\Api\Request\Container\Authorization\PersonalContainer $personalContainer
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderAddress $billingAddressEntity
     *
     * @return void
     */
    protected function mapBillingAddressToPersonalContainer(PersonalContainer $personalContainer, SpySalesOrderAddress $billingAddressEntity)
    {
        $personalContainer->setCountry($billingAddressEntity->getCountry()->getIso2Code());
        $personalContainer->setFirstName($billingAddressEntity->getFirstName());
        $personalContainer->setLastName($billingAddressEntity->getLastName());
        $personalContainer->setSalutation($billingAddressEntity->getSalutation());
        $personalContainer->setCompany($billingAddressEntity->getCompany());
        $personalContainer->setStreet(implode(' ', [$billingAddressEntity->getAddress1(), $billingAddressEntity->getAddress2()]));
        $personalContainer->setAddressAddition($billingAddressEntity->getAddress3());
        $personalContainer->setZip($billingAddressEntity->getZipCode());
        $personalContainer->setCity($billingAddressEntity->getCity());
        $personalContainer->setState($billingAddressEntity->getRegion());
        $personalContainer->setEmail($billingAddressEntity->getEmail());
        $personalContainer->setTelephoneNumber($billingAddressEntity->getPhone());
        $personalContainer->setLanguage($this->getStandardParameter()->getLanguage());
    }

    /**
     * @param \Spryker\Zed\Payone\Business\Api\Request\Container\Authorization\ShippingContainer $shippingContainer
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderAddress $shippingAddressEntity
     *
     * @return void
     */
    protected function mapShippingAddressToShippingContainer(ShippingContainer $shippingContainer, SpySalesOrderAddress $shippingAddressEntity)
    {
        $shippingContainer->setShippingFirstName($shippingAddressEntity->getFirstName());
        $shippingContainer->setShippingLastName($shippingAddressEntity->getLastName());
        $shippingContainer->setShippingCompany($shippingAddressEntity->getCompany());
        $shippingContainer->setShippingStreet($shippingAddressEntity->getAddress1());
        $shippingContainer->setShippingZip($shippingAddressEntity->getZipCode());
        $shippingContainer->setShippingCity($shippingAddressEntity->getCity());
        $shippingContainer->setShippingState($shippingAddressEntity->getRegion());
        $shippingContainer->setShippingCountry($shippingAddressEntity->getCountry()->getIso2Code());
    }

}

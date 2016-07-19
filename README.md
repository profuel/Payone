# Payone Bundle

## Installation

```
composer require spryker/payone
```

## Documentation

[Payone Documentation](http://spryker.github.io/core/bundles/payone)

### How to configure Payone bundle for Spryker Demoshop

#### Add configurations on project level:
* Add Payone controller provider to Yves bootstrap (this is required to provide endpoint url for transaction status callbacks):
in **src/Pyz/Yves/Application/YvesBootstrap.php**
```
use Spryker\Yves\Payone\Plugin\Provider\PayoneControllerProvider;
	…
	protected function registerControllerProviders()
{

	    …

	    $controllerProviders = [

	        …

	        new PayoneControllerProvider($ssl),

	    ];
```
* Optionally configure security firewall for **/payone** route in **Pyz\Yves\Customer\Plugin\Provider\CustomerSecurityServiceProvider**
* Run antelope build yves and include js for credit card check in payment step template (e.g. **src/Pyz/Yves/Checkout/Theme/demoshop/checkout/payment.twig**)
```
{% block content %}

    <script src="/assets/demoshop/js/spryker-yves-payone-main.js"></script>
```

* If needed, add **PaymentPostCheckPlugin** into **src/Pyz/Zed/Checkout/CheckoutDependencyProvider.php**
```
use Spryker\Zed\Payment\Communication\Plugin\Checkout\PaymentPostCheckPlugin;

…

protected function getCheckoutPostHooks(Container $container)
 {

    return [

        new PaymentPostCheckPlugin(),

    ];

}
```

*	Add Payone credentials and configure dependency injectors in local config (to get credentials settings from Payone Merchant Interface, navigate to Configuration -> Payment Portals, click [Edit] next to Zahlungsportal Typ Shop, then open API-Parameter tab):
```
use Spryker\Shared\Application\ApplicationConstants;

use Spryker\Shared\Payone\PayoneConstants;

use Spryker\Shared\Kernel\KernelConstants;

use Spryker\Zed\Oms\OmsConfig;

use Spryker\Shared\Oms\OmsConstants;

use Spryker\Shared\Sales\SalesConstants;

use Spryker\Zed\Payone\PayoneConfig;




$config[PayoneConstants::PAYONE] = [

    PayoneConstants::PAYONE_CREDENTIALS_ENCODING => 'UTF-8',

    PayoneConstants::PAYONE_CREDENTIALS_KEY => ‘***’,

    PayoneConstants::PAYONE_CREDENTIALS_MID => ‘***’,

    PayoneConstants::PAYONE_CREDENTIALS_AID => ‘***’,

    PayoneConstants::PAYONE_CREDENTIALS_PORTAL_ID => ‘***’,

    PayoneConstants::PAYONE_PAYMENT_GATEWAY_URL => 'https://api.pay1.de/post-gateway/',

    PayoneConstants::PAYONE_REDIRECT_SUCCESS_URL => $config[ApplicationConstants::HOST_YVES] . '/checkout/success',

    PayoneConstants::PAYONE_REDIRECT_ERROR_URL => $config[ApplicationConstants::HOST_YVES] . '/checkout/payment',

    PayoneConstants::PAYONE_REDIRECT_BACK_URL => $config[ApplicationConstants::HOST_YVES] . '/checkout/payment',

    PayoneConstants::PAYONE_MODE => 'test',

    PayoneConstants::PAYONE_EMPTY_SEQUENCE_NUMBER => 0
];



$config[KernelConstants::DEPENDENCY_INJECTOR_YVES] = [

    'Checkout' => [

        'Payone'

    ]
];



$config[KernelConstants::DEPENDENCY_INJECTOR_ZED] = [

    'Payment' => [

        'Payone'

    ],

    'Oms' => [

        'Payone'

    ]
];



$config[OmsConstants::PROCESS_LOCATION] = [

    OmsConfig::DEFAULT_PROCESS_LOCATION,

    $config[ApplicationConstants::APPLICATION_SPRYKER_ROOT] . '/Payone/config/Zed/Oms'

];



$config[SalesConstants::PAYMENT_METHOD_STATEMACHINE_MAPPING] = [

    PayoneConfig::PAYMENT_METHOD_CREDIT_CARD => 'PayoneCreditCard'
];


$config[OmsConstants::ACTIVE_PROCESSES] = [

    'PayoneCreditCard',
];
```
#### Configure URLs in Payone Merchant Portal:
* Navigate to Configuration -> Payment Portals, click [Edit] next to Zahlungsportal Typ Shop, then open Extended tab
* Set Success URL, e.g. http://www.de.spryker.dev/checkout/success
* Set Back URL, e.g. http://www.de.spryker.dev/checkout/payment
* Set /payone route for TransactionStatus URL if your website is available online, e.g. http://www.de.spryker.dev/payone
  * Otherwise (for local testing) create new bin on http://mockbin.org/ , set “TSOK” as default response and provide it’s url

#### Testing Payone integration locally
* For testing in local environment, you will have to check new requests on Mockbin after order placement as well as on further order processing (cancellation, shipping and refunds). Request body should be copied and pasted as url params for http://www.de.spryker.dev/payone in browser. After that, console command should be engaged in order to update state machine status:
```
vendor/bin/console oms:check-condition
```


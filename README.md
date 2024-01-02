Magento 2 Extension
=============================================


This is the official Magento 2 extension for Rezolve Instant Checkout.

To learn more about Subscribe Pro you can visit us at https://www.rezolve.com/.

## Getting Started

### Installation via GitHub

You can install our Rezolve Magento 2 extension via our [GitHub](https://github.com/rezolved/magento2-instant-checkout). 

Please run these commands at the root of your Magento install:
 ```bash
 composer config repositories.rezolve git https://github.com/rezolved/magento2-instant-checkout.git
 composer require rezolve/magento2-instant-checkout
 php bin/magento module:enable Rezolve_InstantCheckout
 php bin/magento setup:upgrade
 ```

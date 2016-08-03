# Kirchbergerknorr GoogleTagManager

This module integrates Google tag manager code on every page after body start.
It also adds conversion tracking to checkout and eCommerce tracking to success page.

## How to use?

Go to System->Configuration->Kirchbergerknorr->GoogleTagManager and configure the module that it fits your needs.

### General GoogleTagManager

Here are some general configurations which are needed for the GoogleTagManager to work at all.

#### Activate GoogleTagManager

If this option is active, the GoogleTagManager snippet will be added to every page in the shop.

#### GoogleTagManager ID

Here the GoogleTagManager ID needs to be configured. If the GoogleTagManager is active but no ID is configured, a 
JavaScript error in the frontend will occur because the script cannot be initialized correctly.

#### Page Info Layer

If this option is active, the following variables are added to the data layer:
* pageTitle
* pageUrl
* storeCode
* storeName
* websiteCode
* websiteName
* categoryId
* categoryName
* pageType [cms_page|customer_account|search|product|category|success|checkout]

#### Visitor Info Layer (not implemented yet)

If this option is active, general information about the visitor are added to the data layer.
Possible options are:
* customerState 
* customerId 
* customerGroup 
* browserLanguage
* ...

### Google Conversion Tracking

With this module it is also possible to add conversion tracking information to the data layer on the checkout page.

#### Activate Conversion Info Layer on checkout?
If this option is active, the Conversion information will be added to the data layer. These values are added:
* Nettowarenwert
* Bruttowarenwert

#### Checkout URL path
Here you should configure the path of your checkout page. The default magento path is checkout/onepage/index but it may
vary depending on your checkout extension.

### Google eCommerce Tracking

With this module it is also possible to add eCommerce tracking information to the data layer on the success page.

#### Activate Transactional Info Layer?
If this option is active, transactional information will be added to the data layer. Following variables are added:
* transId
* transDate
* transTotal
* transShipping
* transPaymentType
* transCurrency
* transShippingMethod
* transProducts (per cart item)
  * id
  * name
  * sku
  * category
  * price
  * quantity
  
#### Success page URL path
Here you should configure the path of your success page. The default magento path is checkout/onepage/success but it may
vary depending on your checkout extension.
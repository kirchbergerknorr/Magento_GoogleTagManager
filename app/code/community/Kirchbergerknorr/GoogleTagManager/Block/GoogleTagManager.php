<?php
/**
 * Template Block for GoogleTagManager template
 * app/design/frontend/base/default/template/kirchbergerknorr/googletagmanager/googletagmanager.phtml
 *
 * @category    Kirchbergerknorr
 * @package     Kirchbergerknorr_GoogleTagManager
 * @author      Benedikt Volkmer <bv@kirchbergerknorr.de>
 * @copyright   Copyright (c) 2016 kirchbergerknorr GmbH (http://www.kirchbergerknorr.de)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Kirchbergerknorr_GoogleTagManager_Block_GoogleTagManager extends Mage_Core_Block_Template
{
    /**
     * Helper for fetching the config from backend
     *
     * @var Kirchbergerknorr_GoogleTagManager_Helper_Data
     */
    protected $_configHelper;

    /**
     * Kirchbergerknorr_GoogleTagManager_Block_GoogleTagManager constructor.
     */
    public function __construct()
    {
        $this->_initHelper();
    }

    /**
     * Initialize Kirchbergerknorr_GoogleTagManager_Helper_Data
     */
    protected function _initHelper()
    {
        if (!$this->_configHelper) {
            $this->_configHelper = Mage::helper('kirchbergerknorr_googletagmanager');
        }
    }

    /**
     * Get configured googletagmanager id
     * @return mixed
     */
    public function getGoogleTagManagerId()
    {
        return $this->_configHelper->getGoogleTagManagerId();
    }

    /**
     * Get data layer content
     * @return array
     */
    public function getDataLayerContent()
    {
        //If googletagmanager isn't active, return emtpy array for json encode
        if (!$this->_configHelper->getGoogleTagManagerIsActive()) {
           return array();
        }

        return array_merge($this->_getPageInfo(), $this->_getVisitorInfo(),
            $this->_getConversionInfo(), $this->_getTransactionalInfo());
    }

    /**
     * Possible options:
     * pageTitle / storeCode / storeName / websiteCode / websiteName
     * categoryId / categoryName / pageType [CMS|CATEGORY|PRODUCT|SEARCH|CART|CHECKOUT]
     *
     * @return array
     */
    protected function _getPageInfo()
    {
        // Check if visitor info layer is active
        if (!$this->_configHelper->getPageInfoIsActive()) {
            return array();
        }

        return array(
            'pageTitle' => $this->getLayout()->getBlock('head')->getTitle(),
            'pageUrl' => Mage::helper('core/url')->getCurrentUrl(),
            'storeCode' => Mage::app()->getStore()->getCode(),
            'storeName' => Mage::app()->getStore()->getName(),
            'websiteCode' => Mage::app()->getStore()->getWebsite()->getCode(),
            'websiteName' => Mage::app()->getStore()->getWebsite()->getName(),
            'categoryId' => ($category = Mage::registry('current_category')) ? (int)$category->getId() : null,
            'categoryName' => $category ? $category->getName() : null,
            'pageType' => $this->_getPageType(),

        );
    }

    protected function _getPageType()
    {
        $request = Mage::app()->getRequest();

        $module = strtolower($request->getRouteName());
        $controller = strtolower($request->getControllerName());
        $action = strtolower($request->getActionName());
        $path = $module . '/' . $controller . '/' . $action;

        if ('cms' == $module) {
            return 'cms_page';
        } else if ('customer' == $module) {
            return 'customer_account';
        } else if ('catalogsearch' == $module) {
            return 'search';
        } else if ('catalog/product' == $module . "/" . $controller) {
            return 'product';
        } else if ('catalog/category' == $module . "/" . $controller) {
            return 'category';
        } else if ('onepage/success' == $controller . "/" . $action) {
            return 'success';
        } else if (strpos($path, 'checkout') !== false) {
            // return checkout if there is the string 'checkout' anywhere in the path
            return 'checkout';
        }

        return 'other';
    }

    /**
     * ToDo: Add visitor/customer information here - needed variables have to be defined
     * Possible options:
     * customerState / customerId / customerGroup / browserLanguage / tbd
     *
     * @return array
     */
    protected function _getVisitorInfo()
    {
        // Check if visitor info layer is active
        if (!$this->_configHelper->getVisitorInfoIsActive()) {
            return array();
        }
    }

    /**
     * If ecommerce tracking is active, return transactional infos
     *
     * @return array
     */
    protected function _getTransactionalInfo()
    {
        $data = array();
        $products = array();

        // Check if transactional tracking is active
        if (!$this->_configHelper->getTransactionalInfoIsActive() || !$this->isSuccessPage()) {
            return array();
        }

        $lastOrderId = Mage::getSingleton('checkout/type_onepage')->getCheckout()->getLastOrderId();
        $order = Mage::getModel('sales/order')->load($lastOrderId);

        if ($order) {
            // Get general transaction details
            $data = array(
                'transId' => $order->getIncrementId(),
                'transDate' => date('Y-m-d'),
                'transTotal' => round($order->getBaseGrandTotal(), 2),
                'transTax' => round($order->getBaseTaxAmount(), 2),
                'transShipping' => round($order->getBaseShippingAmount(), 2),
                'transPaymentType' => $order->getPayment()->getMethodInstance()->getTitle(),
                'transCurrency' => Mage::app()->getStore()->getBaseCurrencyCode(),
                'transShippingMethod' => $order->getShippingCarrier() ? $order->getShippingCarrier()->getCarrierCode() : 'No Shipping',
                'transProducts' => array(),
            );

            foreach ($order->getAllVisibleItems() as $orderItem) {
                $categoryIds = $orderItem->getProduct()->getCategoryIds();

                $categories = array();
                foreach ($categoryIds as $categoryId) {
                    $categories[] = Mage::getModel('catalog/category')->load($categoryId)->getName();
                }

                // Generate product info data if not exists in array, else update amount
                if (empty($products[$orderItem->getSku()])) {
                    $products[$orderItem->getSku()] = array(
                        'id' => $orderItem->getProductId(),
                        'name' => $this->jsQuoteEscape(Mage::helper('core')->escapeHtml($orderItem->getName())),
                        'sku' => $this->jsQuoteEscape(Mage::helper('core')->escapeHtml($orderItem->getSku())),
                        'category' => implode('|', $categories),
                        'price' => (double)number_format($orderItem->getBasePrice(), 2, '.', ''),
                        'quantity' => (int)$orderItem->getQtyOrdered(),
                    );
                } else {
                    $products[$orderItem->getSku()]['quantity'] += (int)$orderItem->getQtyOrdered();
                }
            }

            $data['transactionProducts'] = $products;
        }

        return $data;
    }

    /**
     * If conversion tracking is active, return conversion values in checkout
     *
     * @return array
     */
    protected function _getConversionInfo()
    {
        // Check if conversion tracking is active
        if (!$this->_configHelper->getConversionInfoIsActive() || !$this->isCheckout()) {
            return array();
        }

        if ($quote = Mage::getSingleton('checkout/cart')->getQuote()) {
            $totals = $quote->getTotals();
            return array(
                'Nettowarenwert' => $quote->getSubtotal(),
                'Bruttowarenwert' => $totals['subtotal']->getValue() //Get subtotal from totals because it is grandtotal
                                                                     // without shipping
            );
        }

        return array();
    }

    /**
     * Check if current page is checkout
     * @return bool
     */
    protected function isCheckout()
    {
        $requestControllerAction = Mage::app()->getRequest()->getModuleName() . "/" .
            Mage::app()->getRequest()->getControllerName() . "/" .
            Mage::app()->getRequest()->getActionName();

        return $requestControllerAction == $this->_configHelper->getConversionUrlPath();
    }

    /**
     * Check if current page is checkout success
     * @return bool
     */
    protected function isSuccessPage()
    {
        $requestControllerAction = Mage::app()->getRequest()->getModuleName() . "/" .
            Mage::app()->getRequest()->getControllerName() . "/" .
            Mage::app()->getRequest()->getActionName();

        return $requestControllerAction == $this->_configHelper->getEcommerceUrlPath();
    }

}
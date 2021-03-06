<?php
/**
 * Get general configuration
 *
 * @category    Kirchbergerknorr
 * @package     Kirchbergerknorr_Tagmanager
 * @author      Benedikt Volkmer <bv@kirchbergerknorr.de>
 * @copyright   Copyright (c) 2016 kirchbergerknorr GmbH (http://www.kirchbergerknorr.de)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Kirchbergerknorr_GoogleTagManager_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * XML path to enabled config in core config data
     * kirchbergerknorr_googletagmanager/general/active
     *
     * @var string
     */
    const XMLPATH_GOOGLETAGMANAGER_ENABLED = 'kirchbergerknorr_googletagmanager/general/active';

    /**
     * XML path to google id in core config data
     * kirchbergerknorr_googletagmanager/general/id
     *
     * @var string
     */
    const XMLPATH_GOOGLETAGMANAGER_ID = 'kirchbergerknorr_googletagmanager/general/id';

    /**
     * XML path to google id in core config data
     * kirchbergerknorr_googletagmanager/general/pageinfo_active
     *
     * @var string
     */
    const XMLPATH_PAGEINFO_ACTIVE = 'kirchbergerknorr_googletagmanager/general/pageinfo_active';

    /**
     * XML path to google id in core config data
     * kirchbergerknorr_googletagmanager/general/visitorinfo_active
     *
     * @var string
     */
    const XMLPATH_VISITORINFO_ACTIVE = 'kirchbergerknorr_googletagmanager/general/visitorinfo_active';

    /**
     * XML path to google id in core config data
     * kirchbergerknorr_googletagmanager/conversion/active
     *
     * @var string
     */
    const XMLPATH_CONVERSION_ACTIVE = 'kirchbergerknorr_googletagmanager/conversion/active';

    /**
     * XML path to url path of checkout url
     * kirchbergerknorr_googletagmanager/conversion/path
     *
     * @var string
     */
    const XMLPATH_CONVERSION_PATH= 'kirchbergerknorr_googletagmanager/conversion/path';

    /**
     * XML path to conversion event
     * kirchbergerknorr_googletagmanager/conversion/event
     *
     * @var string
     */
    const XMLPATH_CONVERSION_EVENT= 'kirchbergerknorr_googletagmanager/conversion/event';

    /**
     * XML path to google id in core config data
     * kirchbergerknorr_googletagmanager/general/transactional_active
     *
     * @var string
     */
    const XMLPATH_ECOMMERCE_ACTIVE = 'kirchbergerknorr_googletagmanager/ecommerce/active';

    /**
     * XML path to url path of checkout url
     * kirchbergerknorr_googletagmanager/conversion/path
     *
     * @var string
     */
    const XMLPATH_ECOMMERCE_PATH= 'kirchbergerknorr_googletagmanager/ecommerce/path';


    /**
     * XML path to ecommerce event
     * kirchbergerknorr_googletagmanager/ecommerce/event
     *
     * @var string
     */
    const XMLPATH_ECOMMERCE_EVENT= 'kirchbergerknorr_googletagmanager/ecommerce/event';

    /**
     * XML path to the HTML position configuration
     */
    const XMLPATH_HTML_POSITION = 'kirchbergerknorr_googletagmanager/general/html_position';

    /**
     * Returns if googletagmanager is active from configuration
     * path kirchbergerknorr_googletagmanager/general/active
     *
     * @param integer $storeId
     * @return mixed
     */
    public function getGoogleTagManagerIsActive($storeId = null)
    {
        return Mage::getStoreConfig(self::XMLPATH_GOOGLETAGMANAGER_ENABLED, $storeId);
    }

    /**
     * Returns if configured googletagmanager id from configuration
     * path kirchbergerknorr_googletagmanager/general/id
     *
     * @param integer $storeId
     * @return mixed
     */
    public function getGoogleTagManagerId($storeId = null)
    {
        return Mage::getStoreConfig(self::XMLPATH_GOOGLETAGMANAGER_ID, $storeId);
    }

    /**
     * Returns if pageinfo datalayer is active
     * path kirchbergerknorr_googletagmanager/general/pageinfo_active
     *
     * @param integer $storeId
     * @return mixed
     */
    public function getPageInfoIsActive($storeId = null)
    {
        return Mage::getStoreConfig(self::XMLPATH_PAGEINFO_ACTIVE, $storeId);
    }

    /**
     * Returns if visitor info datalayer is active
     * path kirchbergerknorr_googletagmanager/general/pageinfo_active
     *
     * @param integer $storeId
     * @return mixed
     */
    public function getVisitorInfoIsActive($storeId = null)
    {
        return Mage::getStoreConfig(self::XMLPATH_VISITORINFO_ACTIVE, $storeId);
    }

    /**
     * Returns if conversion info datalayer is active
     * path kirchbergerknorr_googletagmanager/general/conversion_active
     *
     * @param integer $storeId
     * @return mixed
     */
    public function getConversionInfoIsActive($storeId = null)
    {
        return Mage::getStoreConfig(self::XMLPATH_CONVERSION_ACTIVE, $storeId);
    }

    /**
     * Returns if conversion url path
     * path kirchbergerknorr_googletagmanager/conversion/path
     *
     * @param integer $storeId
     * @return mixed
     */
    public function getConversionUrlPath($storeId = null)
    {
        return Mage::getStoreConfig(self::XMLPATH_CONVERSION_PATH, $storeId);
    }

    /**
     * Returns if transactional info datalayer is active
     * path kirchbergerknorr_googletagmanager/general/transactional_active
     *
     * @param integer $storeId
     * @return mixed
     */
    public function getTransactionalInfoIsActive($storeId = null)
    {
        return Mage::getStoreConfig(self::XMLPATH_CONVERSION_PATH, $storeId);
    }

    /**
     * Returns if ecommerce url path
     * path kirchbergerknorr_googletagmanager/ecommerce/path
     *
     * @param integer $storeId
     * @return mixed
     */
    public function getEcommerceUrlPath($storeId = null)
    {
        return Mage::getStoreConfig(self::XMLPATH_ECOMMERCE_PATH, $storeId);
    }

    /**
     * Returns event to fire on conversion
     * path kirchbergerknorr_googletagmanager/conversion/event
     *
     * @param integer $storeId
     * @return mixed
     */
    public function getConversionEvent($storeId = null)
    {
        return Mage::getStoreConfig(self::XMLPATH_CONVERSION_EVENT, $storeId);
    }

    /**
     * Returns event to fire on ecommerce
     * path kirchbergerknorr_googletagmanager/ecommerce/event
     *
     * @param integer $storeId
     * @return mixed
     */
    public function getEcommerceEvent($storeId = null)
    {
        return Mage::getStoreConfig(self::XMLPATH_ECOMMERCE_EVENT, $storeId);

    }

    /**
     * Get HTML position of the Google Tag Manager code
     *
     * @param int $storeId
     *
     * @return mixed
     */
    public function getGoogleTagManagerHtmlPosition($storeId = null)
    {
        return Mage::getStoreConfig(self::XMLPATH_HTML_POSITION, $storeId);
    }
}
<?php
/**
 * Update layout according to backend configuration
 *
 * @category    Kirchbergerknorr
 * @package     Kirchbergerknorr_Tagmanager
 * @author      Benedikt Volkmer <bv@kirchbergerknorr.de>
 * @copyright   Copyright (c) 2016 kirchbergerknorr GmbH (http://www.kirchbergerknorr.de)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Kirchbergerknorr_GoogleTagManager_Model_Observer
{
    /**
     * Layout update code snippet
     *
     * @var string
     */
    protected $layoutUpdateSnippet;

    /**
     * Contains the current layout object
     *
     * @var Mage_Core_Model_Layout
     */
    private $_layout;

    /**
     * Contains the current layout update object
     *
     * @var Mage_Core_Model_Layout_Update
     */
    private $_layoutUpdate;

    public function updateLayout(Varien_Event_Observer $observer)
    {
        if(Mage::app()->getRequest()->isPost()){
            return $this;
        }

        /** @var $configHelper Kirchbergerknorr_GoogleTagManager_Helper_Data */
        $configHelper = Mage::helper('kirchbergerknorr_googletagmanager');

        if ($configHelper->getGoogleTagManagerIsActive()) {

            $this->layoutUpdateSnippet =
                '<reference name="' . $configHelper->getGoogleTagManagerHtmlPosition() . '">
                    <block type="kirchbergerknorr_googletagmanager/googletagmanager" name="kk_googletagmanager" as="kk_googletagmanager" template="kirchbergerknorr/googletagmanager/googletagmanager.phtml" />
                </reference>';

            // Get current layout
            $this->_layout = $observer->getEvent()->getLayout();

            // Get layout update
            $this->_layoutUpdate = $this->_layout->getUpdate();

            $this->_addLayoutUpdate($this->layoutUpdateSnippet);
        }

        return $this;
    }

    /**
     * Add a layout update to the current layout object
     *
     * @param $update
     */
    protected function _addLayoutUpdate($update)
    {
        if (is_array($update)) {
            // If update is an array, add all updates
            foreach ($update as $_update) {
                $this->_layoutUpdate->addUpdate($_update);
            }
        } else {
            $this->_layoutUpdate->addUpdate($update);
        }

        $this->_layout->generateXml();
    }
}
<?php


class Zip_Payment_Block_Checkout extends Mage_Core_Block_Template
{

    const CONFIG_DISPLAY_MODE_PATH = 'payment/zip_payment/display_mode';
    const CONFIG_CHECKOUT_SCRIPT_LIB_PATH = 'payment/zip_payment/checkout/js_lib';
    const CONFIG_CHECKOUT_LOADER_IMAGE_PATH = 'payment/zip_payment/checkout/loader_image';

    /**
     * @var Zip_Payment_Model_Config
     */
    protected $config;

    /**
     * Config instance getter
     * @return Zip_Payment_Model_Config
     */
    public function getConfig()
    {
        if ($this->config == null) {
            $this->config = Mage::getSingleton('zip_payment/config');
        }
        return $this->config;
    }

    public function getLibScript() {
        return $this->getConfig()->getValue(self::CONFIG_CHECKOUT_SCRIPT_LIB_PATH);
    }

    public function getMethodCode() {
        return $this->getConfig()->getMethodCode();
    }

    public function getLoaderImageUrl() {
        return $this->getConfig()->getValue(self::CONFIG_CHECKOUT_LOADER_IMAGE_PATH);
    }

     /**
     * Returns the checkout url.
     *
     * @return string
     */
    public function getCheckoutUrl()
    {
        return Mage::helper('zip_payment')->getUrl(Zip_Payment_Model_Config::CHECKOUT_URL_ROUTE);
    }

    /**
     * Returns the response url.
     *
     * @return string
     */
    public function getResponseUrl()
    {
        return Mage::helper('zip_payment')->getUrl(Zip_Payment_Model_Config::CHECKOUT_RESPONSE_URL_ROUTE) . '?' . Zip_Payment_Controller_Checkout::URL_PARAM_RESULT . '=';
    }

    /**
     * Whether to use redirect or not.
     *
     * @return bool
     */
    public function isRedirect()
    {
        return $this->getConfig()->getValue(self::CONFIG_DISPLAY_MODE_PATH) == Zip_Payment_Model_Adminhtml_System_Config_Source_DisplayMode::DISPLAY_MODE_REDIRECT;
    }

    /**
     * Returns the extension name if specified in the config otherwise picks up from the request
     *
     * @return string
     */
    public function getExtensionName()
    {
        /** Check if extension name has been set explicitly in the zip_payment.xml in the appropriate layout handle for the checkout page 
        * E.g.
        * <action method="setData">
        *    <name>extension_name</name>
        *     <value>Mage_Checkout</value>
        *  </action>
        *
        */
        if ($extension = $this->getData('extension_name')) {
            return $extension;
        } else {
            return strtolower(Mage::app()->getRequest()->getControllerModule());
        }
    }

    /**
     * Returns the extension name if specified in the config otherwise picks up from the request
     *
     * @return string
     */
    public function getRedirectAfterPayment()
    {
        /** Check if extension name has been set explicitly in the zip_payment.xml in the appropriate layout handle for the checkout page
         * E.g.
         * <action method="setData">
         *    <name>redirect_after_payment</name>
         *     <value>1</value>
         *  </action>
         *
         */
        return (int)$this->getData('redirect_after_payment');
    }

    public function getLogLevel() {

        if($this->getConfig()->isDebugEnabled() && $this->getConfig()->isLogEnabled()) {
            
            $logLevel = $this->getConfig()->getLogLevel();

            if($logLevel > Zend_Log::ERR) {
                return 'Information';
            }
            else if($logLevel > Zend_Log::DEBUG) {
                return 'Error';
            }
            else {
                return 'Debug';
            }
        }

        return '';
    }
    
}
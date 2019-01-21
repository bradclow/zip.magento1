<?php

/**
 * Block model for widgets
 * 
 * @package     Zip_Payment
 * @author      Zip Co - Plugin Team
 *
 **/

class Zip_Payment_Block_Widget extends Zip_Payment_Block_Template
{

    const CONFIG_WIDGET_PATH_PREFIX = 'payment/zip_payment/widgets/';
    const CONFIG_WIDGETS_ENABLED_PATH = 'payment/zip_payment/widgets/enabled';
    const CONFIG_WIDGETS_LIB_SCRIPT_PATH = 'payment/zip_payment/widgets/js_lib';
    
    const CONFIG_PUBLIC_KEY_PATH = 'payment/zip_payment/public_key';
    const CONFIG_ENVIRONMENT_PATH = 'payment/zip_payment/environment';
    const CONFIG_HOME_PAGE_PATH = 'web/default/cms_home_page';
    
    const ROOT_WIDGET_TYPES = array('head', 'root', 'popup');
    const SUPPORTED_WIDGET_TYPES = array('widget', 'banner', 'tagline', 'inline');

    /**
     * get merchant id from public key
     */
    public function getMerchantId() {
        return $this->getConfig()->getValue(self::CONFIG_PUBLIC_KEY_PATH);
    }

    /**
     * get current environment
     */
    public function getEnvironment() {
        return $this->getConfig()->getValue(self::CONFIG_ENVIRONMENT_PATH);
    }

    /**
     * get url of widget js library
     */
    public function getLibScript() {
        return $this->getConfig()->getValue(self::CONFIG_WIDGETS_LIB_SCRIPT_PATH);
    }


    /**
     * check is one widget type is enabled / active
     */
    protected function isActive($widgetType) 
    {
        if($this->getModelHelper()->isActive() && $this->getConfig()->getFlag(self::CONFIG_WIDGETS_ENABLED_PATH)) {

            $pageType = $this->getWidgetPageType();
   
            if(!empty($pageType)) {

                if(in_array($widgetType, self::ROOT_WIDGET_TYPES)) {

                    foreach(self::SUPPORTED_WIDGET_TYPES as $supportedWidgetType) {
                        
                        if($pageType == 'landing') {
                            $path = self::CONFIG_WIDGET_PATH_PREFIX . $pageType . '_page/enabled';
                        }
                        else {
                            $path = self::CONFIG_WIDGET_PATH_PREFIX . $pageType . '_page/' . $supportedWidgetType;
                        }
                        
                        $enabled = $this->getConfig()->getValue($path);
                        
                        /**
                         * Make sure there one widget type is enable for current page type
                         */
                        if(!is_null($enabled) && boolval($enabled)) {
                            return true;
                        }
                    }
    
                    return false;
    
                }
                elseif(in_array($widgetType, self::SUPPORTED_WIDGET_TYPES)) {
    
                    if(!empty($widgetType)) {
                        $path = self::CONFIG_WIDGET_PATH_PREFIX . $pageType . '_page/' . $widgetType;
                        return $this->getConfig()->getFlag($path);
                    }
    
                }

            }

        }

        return false;
    }

    /**
     * Returns the current page type.
     *
     * @return string
     */
    protected function getWidgetPageType()
    {
        $pageIdentifier = $this->getModelHelper()->getPageIdentifier();

        if($this->getModelHelper()->isOnepageCheckout() || $this->getModelHelper()->isOnestepCheckout()) {
            return 'checkout';
        }

        switch($pageIdentifier){
            case 'cms_index_index': return 'home';
            case 'catalog_product_view': return 'product'; 
            case 'catalog_category_view': return 'category'; 
            case 'checkout_cart_index': return 'cart';
            case 'cms_page_view': return 'landing';
        }

        return null;
    }

    
}
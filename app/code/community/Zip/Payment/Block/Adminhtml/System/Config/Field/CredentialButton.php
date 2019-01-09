<?php

/**
 * Block class of Admin credential buttons
 * 
 * @package     Zip_Payment
 * @author      Zip Co - Plugin Team
 *
 **/

class Zip_Payment_Block_Adminhtml_System_Config_Field_CredentialButton extends Mage_Adminhtml_Block_System_Config_Form_Field
{

    const CONFIG_PORTAL_SANDBOX_PATH = 'payment/zip_payment/portal/sandbox';
    const CONFIG_PORTAL_PRODUCTION_PATH = 'payment/zip_payment/portal/production';

    /**
     * @var string
     */
    protected $template = 'zip/payment/system/config/field/credential_button.phtml';

    /**
     * Config model instance
     *
     * @var Zip_Payment_Model_Config
     */
    protected $config = null;

    /**
     * Set template to itself
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if (!$this->getTemplate()) {
            $this->setTemplate($this->template);
        }
        return $this;
    }

    /**
     * Unset some non-related element parameters
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
        return parent::render($element);
    }

    protected function getConfig() {
        if($this->config == null) {
            $this->config = Mage::getSingleton('zip_payment/config');
        }
        return $this->config;
    }

    /**
     * Get the button and scripts contents
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $originalData = $element->getOriginalData();
        $elementHtmlId = $element->getHtmlId();

        $this->addData(
            array(
                'production_text' =>  Mage::helper('zip_payment')->__('Find your Production keys'),
                'production_url' => $this->getConfig()->getValue(self::CONFIG_PORTAL_PRODUCTION_PATH),
                'sandbox_text' =>  Mage::helper('zip_payment')->__('Find your Sandbox keys'),
                'sandbox_url' => $this->getConfig()->getValue(self::CONFIG_PORTAL_SANDBOX_PATH),
                'html_id' => $elementHtmlId,
            )
        );
        return $this->_toHtml();
    }

}

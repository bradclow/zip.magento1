<?php

/**
 * Configuration model for checkout type
 *
 * @package Zip_Payment
 * @author  Zip Co - Plugin Team
 **/


class Zip_Payment_Model_Adminhtml_System_Config_Source_CheckoutType
{

    const CHECKOUT_TYPE_ONE_PAGE = 'one_page';
    const CHECK_TYPE_ONE_STEP = 'one_step';

    /**
     * Returns the display mode option array.
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array(
                'value' => self::CHECKOUT_TYPE_ONE_PAGE,
                'label' => Mage::helper('zip_payment')->__('One Page Checkout')
            ),
            array(
                'value' => self::CHECK_TYPE_ONE_STEP,
                'label' => Mage::helper('zip_payment')->__('One Step Checkout')
            )
        );
    }

}

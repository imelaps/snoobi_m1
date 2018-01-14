<?php

class Snoobi_Snoobi_Model_System_Config_Source_Cookies
{
    /**
     * Get available options
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array(
                'value' => Snoobi_Snoobi_Helper_Data::COOKIES_ON,
                'label' => Mage::helper('snoobi')->__('On')
            ),
            array(
                'value' => Snoobi_Snoobi_Helper_Data::COOKIES_1ST,
                'label' => Mage::helper('snoobi')->__('1st')
            ),
            array(
                'value' => Snoobi_Snoobi_Helper_Data::COOKIES_OFF,
                'label' => Mage::helper('snoobi')->__('Off')
            )
        );
    }
}

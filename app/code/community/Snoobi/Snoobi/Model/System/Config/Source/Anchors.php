<?php

class Snoobi_Snoobi_Model_System_Config_Source_Anchors
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
                'value' => Snoobi_Snoobi_Helper_Data::ANCHORS_ON,
                'label' => Mage::helper('snoobi')->__('On')
            ),
            array(
                'value' => Snoobi_Snoobi_Helper_Data::ANCHORS_OFF,
                'label' => Mage::helper('snoobi')->__('Off')
            )
        );
    }
}

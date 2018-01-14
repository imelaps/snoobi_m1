<?php

class Snoobi_Snoobi_Model_Observer
{
    public function setSnoobiOnOrderSuccessPageView(Varien_Event_Observer $observer)
    {
        $orderIds = $observer->getEvent()->getOrderIds();
        if (empty($orderIds) || !is_array($orderIds)) {
            return;
        }
        $block = Mage::app()->getFrontController()->getAction()->getLayout()->getBlock('snoobi_analytics');
        if ($block) {
            $block->setOrderIds($orderIds);
        }
    }
}

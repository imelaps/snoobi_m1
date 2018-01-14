<?php

class Snoobi_Snoobi_Block_Analytics extends Mage_Core_Block_Template
{
    public function isAvailable()
    {
        return Mage::helper('snoobi')->isAvailable();
    }

    public function getAccount()
    {
        return Mage::helper('snoobi')->getAccount();
    }

    public function getCookies()
    {
        return Mage::helper('snoobi')->getCookies();
    }

    public function getAnchors()
    {
        return Mage::helper('snoobi')->getCookies();
    }

    public function getOrdersTrackingCode()
    {
        $orderIds = $this->getOrderIds();
        if (empty($orderIds) || !is_array($orderIds)) {
            return;
        }

        $collection = Mage::getResourceModel('sales/order_collection');
        $collection->addFieldToFilter('entity_id', array('in' => $orderIds));

        $result = array();
        $j = 0;
        $result[] = 'var snoobiTrans = new SnoobiTrans();';
        foreach ($collection as $order) {
            // Order data
            $result[] = ((!$j)?'var ':'') . 'snoobiOrder = snoobiTrans.order("' . $order->getIncrementId() . '");';
            // Billing address fields
            if ($billingAddress = $order->getBillingAddress()) {
                if ($email = $billingAddress->getEmail()) {
                    $result[] = 'snoobiOrder.billingEmail = "' . $email . '";';
                }
                if ($firstname = $billingAddress->getFirstname()) {
                    $result[] = 'snoobiOrder.billingFirstname = "' . $firstname . '";';
                }
                if ($lastname = $billingAddress->getLastname()) {
                    $result[] = 'snoobiOrder.billingLastname = "' . $lastname . '";';
                }
                if ($company = $billingAddress->getCompany()) {
                    $result[] = 'snoobiOrder.billingCompany = "' . $company . '";';
                }
                if ($street = $billingAddress->getStreet()) {
                    $result[] = 'snoobiOrder.billingStreet = "' . implode(', ', $street) . '";';
                }
                if ($zip = $billingAddress->getPostcode()) {
                    $result[] = 'snoobiOrder.billingZip = "' . $zip . '";';
                }
                if ($city = $billingAddress->getCity()) {
                    $result[] = 'snoobiOrder.billingCity = "' . $city . '";';
                }
                if ($state = $billingAddress->getRegion()) {
                    $result[] = 'snoobiOrder.billingRegion = "' . $state . '";';
                }
                if ($country = $billingAddress->getCountryId()) {
                    $result[] = 'snoobiOrder.billingCountry = "' . $country . '";';
                }
                if ($phone = $billingAddress->getTelephone()) {
                    $result[] = 'snoobiOrder.billingPhone = "' . $phone . '";';
                }
            }

            // Shipping address fields
            if ($shippingAddress = $order->getShippingAddress()) {
                if ($email = $shippingAddress->getEmail()) {
                    $result[] = 'snoobiOrder.shippingEmail = "' . $email . '";';
                }
                if ($firstname = $shippingAddress->getFirstname()) {
                    $result[] = 'snoobiOrder.shippingFirstname = "' . $firstname . '";';
                }
                if ($lastname = $shippingAddress->getLastname()) {
                    $result[] = 'snoobiOrder.shippingLastname = "' . $lastname . '";';
                }
                if ($company = $shippingAddress->getCompany()) {
                    $result[] = 'snoobiOrder.shippingCompany = "' . $company . '";';
                }
                if ($street = $shippingAddress->getStreet()) {
                    $result[] = 'snoobiOrder.shippingStreet = "' . implode(', ', $street) . '";';
                }
                if ($zip = $shippingAddress->getPostcode()) {
                    $result[] = 'snoobiOrder.shippingZip = "' . $zip . '";';
                }
                if ($city = $shippingAddress->getCity()) {
                    $result[] = 'snoobiOrder.shippingCity = "' . $city . '";';
                }
                if ($state = $shippingAddress->getRegion()) {
                    $result[] = 'snoobiOrder.shippingRegion = "' . $state . '";';
                }
                if ($country = $shippingAddress->getCountryId()) {
                    $result[] = 'snoobiOrder.shippingCountry = "' . $country . '";';
                }
                if ($phone = $shippingAddress->getTelephone()) {
                    $result[] = 'snoobiOrder.shippingPhone = "' . $phone . '";';
                }
            }

            $result[] = 'snoobiOrder.total = "' . $order->getBaseGrandTotal() . '";';
            $result[] = 'snoobiOrder.currency = "' . $order->getBaseCurrencyCode() . '";';
            $result[] = 'snoobiOrder.shippingCosts = "' . $order->getBaseShippingAmount() . '";';
            $result[] = 'snoobiOrder.tax = "' . $order->getBaseTaxAmount() . '";';
            $result[] = 'snoobiOrder.coupons = "' . $order->getCouponCode() . '";';
            $result[] = 'snoobiOrder.turnover = "' . ( $order->getBaseGrandTotal() - $order->getBaseTaxAmount() ) . '";';
            $result[] = 'snoobiOrder.shippingMethod = "' . $order->getShippingDescription() . '";';
            $result[] = 'snoobiOrder.discount = "' . $order->getDiscountAmount() . '";';
            $result[] = 'snoobiOrder.discountPct = "' . ($order->getDiscountAmount()/$order->getBaseGrandTotal())*100 . '";';

            // Get payment method
            $payment = $order->getPayment();
            if ($payment && $method = $payment->getMethodInstance()) {
                $result[] = 'snoobiOrder.paymentMethod = "' . $method->getTitle() . '";';
            }

            // Order items
            $i = 0;
            foreach ($order->getAllVisibleItems() as $item) {
                $result[] = ((!$i)?'var ':'') .'orderedItem = snoobiOrder.item("' . $item->getId() . '");';

                $result[] = 'orderedItem.name = "' . Mage::helper('snoobi')->escapeJsQuote($item->getName()) . '";';
                $result[] = 'orderedItem.sku = "' . $item->getSku() . '";';
                $result[] = 'orderedItem.price = "' . $item->getBasePrice() . '";';
                $result[] = 'orderedItem.amount = "' . $item->getQtyOrdered() . '";';

                $result[] = 'orderedItem.discount = "'.$item->getDiscountAmount().'";';
                $result[] = 'orderedItem.discountPct = "'.(($item->getDiscountAmount()/$item->getBasePrice())*100).'";';

		$_cats=$item->getProduct()->getCategoryIds();
		$category = Mage::getModel('catalog/category')->setStoreId(Mage::app()->getStore()->getId())->load($_cats[0]);
                $result[] = 'orderedItem.category = "'.$category->getName().'";';

                $i++;
            }

            $j++;
        }

        return implode("\n", $result);
    }

}

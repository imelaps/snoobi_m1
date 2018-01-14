<?php

class Snoobi_Snoobi_Helper_Data extends Mage_Core_Helper_Abstract
{
    const ANCHORS_ON = 'on';
    const ANCHORS_OFF = 'off';

    const COOKIES_ON = 'on';
    const COOKIES_1ST = '1st';
    const COOKIES_OFF = 'off';

    const XML_PATH_ACTIVE   = 'snoobi/analytics/active';
    const XML_PATH_ACCOUNT  = 'snoobi/analytics/account';
    const XML_PATH_ANCHORS  = 'snoobi/analytics/anchors';
    const XML_PATH_COOKIES  = 'snoobi/analytics/cookies';

    public function isAvailable()
    {
        $accountId = $this->getAccount();
        return $accountId && Mage::getStoreConfigFlag(self::XML_PATH_ACTIVE, null);
    }

    public function getAccount()
    {
        return Mage::getStoreConfig(self::XML_PATH_ACCOUNT, null);
    }

    public function getCookies()
    {
        return Mage::getStoreConfig(self::XML_PATH_COOKIES, null);
    }

    public function getAnchors()
    {
        return Mage::getStoreConfig(self::XML_PATH_ANCHORS, null);
    }

    public function escapeJsQuote($data, $quote = '\'')
    {
        if (is_array($data)) {
            $result = [];
            foreach ($data as $item) {
                $result[] = $this->escapeJsQuote($item, $quote);
            }
        } else {
            $result = str_replace($quote, '\\' . $quote, $data);
        }
        return $result;
    }
}

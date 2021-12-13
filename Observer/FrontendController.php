<?php

namespace Selectj\SpeedSuite\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Selectj\SpeedSuite\Helper\Data;


class FrontendController implements ObserverInterface
{

    /**
     * @var Data
     */
    private Data $helper;

    /**
     * @param Data $helper
     */
    public function __construct(
        Data $helper
    ){
        $this->helper = $helper;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        if (!$this->helper->isDeferJsEnabled())
            return;

        $response = $observer->getEvent()->getData('response');
        if (!$response)
            return;
        $html = $response->getBody();
        if ($html == '')
            return;
        $conditionalJsPattern = '@(?:<script type="text/javascript"|<script)(.*)</script>@msU';
        preg_match_all($conditionalJsPattern, $html, $_matches);
        $_js_if = implode('', $_matches[0]);
        $html = preg_replace($conditionalJsPattern, '', $html);
        $html .= $_js_if;
        $response->setBody($html);
    }
}
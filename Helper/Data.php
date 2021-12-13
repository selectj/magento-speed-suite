<?php

namespace Selectj\SpeedSuite\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{

    const DEFER_JS_ENABLE = 'speedsuite/defer_js_load/general/enabled';


    /**
     * @param Context $context
     */
    public function __construct(Context $context
    ){
        parent::__construct($context);
    }

    /**
     * @param $configPath
     * @return bool
     */
    public function getStoreConfig($configPath): bool
    {
        return $this->scopeConfig->getValue(
            $configPath,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return bool
     */
    public function isDeferJsEnabled() : bool
    {
        return $this->getStoreConfig(self::DEFER_JS_ENABLE);
    }
}
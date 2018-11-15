<?php
declare(strict_types=1);

/**
 * Class Configuration
 * @package Val\AdvancedContactUs\Helper
 */

namespace Val\AdvancedContactUs\Helper;

class Configuration extends \Magento\Framework\App\Helper\AbstractHelper
{
    const CONFIG_MODULE_ENABLED_PATH = 'advanced_contact_us/general/enabled';

    /**
     * Get is module enabled status
     *
     * @return bool
     */
    public function isModuleEnabled(): bool
    {
        $status = $this->scopeConfig->getValue(
            self::CONFIG_MODULE_ENABLED_PATH,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        return ($status) ? true : false;
    }
}

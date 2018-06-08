<?php
/**
 * @package Custom_Module
 * @author  Deepak K
 * @copyright Copyright © 2018 Corra. All rights reserved.
 */

namespace Custom\Module\Block;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\View\Element\Template;

class Slider extends Template
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * Slider constructor.
     * @param Template\Context $context
     * @param ScopeConfigInterface $scopeConfig
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        ScopeConfigInterface $scopeConfig,
        array $data = []
    )
    {
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context, $data);
    }

    /**
     * @override
     * @see \Magento\Backend\Block\AbstractBlock::_construct()
     * @return void
     */
    protected function _construct() {
        $om = ObjectManager::getInstance();

        $page = $om->get('Magento\Framework\View\Page\Config');
        $page->addPageAsset('Custom_Module::css/flexslider.css');
        $page->addPageAsset('Custom_Module::js/jquery.min.js');
        $page->addPageAsset('Custom_Module::js/jquery.easing.js');
        $page->addPageAsset('Custom_Module::js/jquery.mousewheel.js');
        $page->addPageAsset('Custom_Module::js/shCore.js');
        $page->addPageAsset('Custom_Module::js/jquery.flexslider.js');
        $page->addPageAsset('Custom_Module::js/scripts.js');
    }
}
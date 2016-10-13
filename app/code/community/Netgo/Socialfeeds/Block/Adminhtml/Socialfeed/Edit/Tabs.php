<?php
/**
 * Netgo_Socialfeeds extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       Netgo
 * @package        Netgo_Socialfeeds
 * @copyright      Copyright (c) 2015
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Socialfeed admin edit tabs
 *
 * @category    Netgo
 * @package     Netgo_Socialfeeds
 * @author      Ultimate Module Creator
 */
class Netgo_Socialfeeds_Block_Adminhtml_Socialfeed_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * Initialize Tabs
     *
     * @access public
     * @author Ultimate Module Creator
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('socialfeed_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('netgo_socialfeeds')->__('Socialfeed'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return Netgo_Socialfeeds_Block_Adminhtml_Socialfeed_Edit_Tabs
     * @author Ultimate Module Creator
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_socialfeed',
            array(
                'label'   => Mage::helper('netgo_socialfeeds')->__('Socialfeed'),
                'title'   => Mage::helper('netgo_socialfeeds')->__('Socialfeed'),
                'content' => $this->getLayout()->createBlock(
                    'netgo_socialfeeds/adminhtml_socialfeed_edit_tab_form'
                )
                ->toHtml(),
            )
        );
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve socialfeed entity
     *
     * @access public
     * @return Netgo_Socialfeeds_Model_Socialfeed
     * @author Ultimate Module Creator
     */
    public function getSocialfeed()
    {
        return Mage::registry('current_socialfeed');
    }
}

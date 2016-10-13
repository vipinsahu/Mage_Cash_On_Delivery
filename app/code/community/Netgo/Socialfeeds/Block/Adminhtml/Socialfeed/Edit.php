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
 * Socialfeed admin edit form
 *
 * @category    Netgo
 * @package     Netgo_Socialfeeds
 * @author      Ultimate Module Creator
 */
class Netgo_Socialfeeds_Block_Adminhtml_Socialfeed_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * constructor
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function __construct()
    {
        parent::__construct();
        $this->_blockGroup = 'netgo_socialfeeds';
        $this->_controller = 'adminhtml_socialfeed';
        $this->_updateButton(
            'save',
            'label',
            Mage::helper('netgo_socialfeeds')->__('Save Socialfeed')
        );
        $this->_updateButton(
            'delete',
            'label',
            Mage::helper('netgo_socialfeeds')->__('Delete Socialfeed')
        );
        $this->_addButton(
            'saveandcontinue',
            array(
                'label'   => Mage::helper('netgo_socialfeeds')->__('Save And Continue Edit'),
                'onclick' => 'saveAndContinueEdit()',
                'class'   => 'save',
            ),
            -100
        );
        $this->_formScripts[] = "
            function saveAndContinueEdit() {
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    /**
     * get the edit form header
     *
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
    public function getHeaderText()
    {
        if (Mage::registry('current_socialfeed') && Mage::registry('current_socialfeed')->getId()) {
            return Mage::helper('netgo_socialfeeds')->__(
                "Edit Socialfeed '%s'",
                $this->escapeHtml(Mage::registry('current_socialfeed')->getSocialfeedsStatus())
            );
        } else {
            return Mage::helper('netgo_socialfeeds')->__('Add Socialfeed');
        }
    }
}

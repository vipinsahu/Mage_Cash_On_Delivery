<?php
/***************************************
 *** Cash On Delivery ***
 ***************************************
 *
 * @copyright   Copyright (c) 2015
 * @company     NetAttingo Technologies
 * @package     Netgo_Cod
 * @author 		NetGo
 * @dev			netattingomails@gmail.com
 *
 */
class Netgo_Cod_Block_Adminhtml_Cod_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * constructor
     *
     * @access public
     * @return void
     * @author NetGo
     */
    public function __construct()
    {
        parent::__construct();
        $this->_blockGroup = 'netgo_cod';
        $this->_controller = 'adminhtml_cod';
        $this->_updateButton(
            'save',
            'label',
            Mage::helper('netgo_cod')->__('Save COD')
        );
        $this->_updateButton(
            'delete',
            'label',
            Mage::helper('netgo_cod')->__('Delete COD')
        );
        $this->_addButton(
            'saveandcontinue',
            array(
                'label'   => Mage::helper('netgo_cod')->__('Save And Continue Edit'),
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
     * @author NetGo
     */
    public function getHeaderText()
    {
        if (Mage::registry('current_cod') && Mage::registry('current_cod')->getId()) {
            return Mage::helper('netgo_cod')->__(
                "Edit COD '%s'",
                $this->escapeHtml(Mage::registry('current_cod')->getZipcode())
            );
        } else {
            return Mage::helper('netgo_cod')->__('Add COD');
        }
    }
}

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
class Netgo_Cod_Block_Adminhtml_Cod_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * Initialize Tabs
     *
     * @access public
     * @author NetGo
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('cod_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('netgo_cod')->__('COD'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return Netgo_Cod_Block_Adminhtml_Cod_Edit_Tabs
     * @author NetGo
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_cod',
            array(
                'label'   => Mage::helper('netgo_cod')->__('COD'),
                'title'   => Mage::helper('netgo_cod')->__('COD'),
                'content' => $this->getLayout()->createBlock(
                    'netgo_cod/adminhtml_cod_edit_tab_form'
                )
                ->toHtml(),
            )
        );
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve cod entity
     *
     * @access public
     * @return Netgo_Cod_Model_Cod
     * @author NetGo
     */
    public function getCod()
    {
        return Mage::registry('current_cod');
    }
}

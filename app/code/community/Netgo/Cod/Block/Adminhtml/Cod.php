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
class Netgo_Cod_Block_Adminhtml_Cod extends Mage_Adminhtml_Block_Widget_Grid_Container
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
        $this->_controller         = 'adminhtml_cod';
        $this->_blockGroup         = 'netgo_cod';
        parent::__construct();
        $this->_headerText         = Mage::helper('netgo_cod')->__('COD');
        $this->_updateButton('add', 'label', Mage::helper('netgo_cod')->__('Add COD'));

    }
}

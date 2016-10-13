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
class Netgo_Cod_Block_Cod_View extends Mage_Core_Block_Template
{
    /**
     * get the current cod
     *
     * @access public
     * @return mixed (Netgo_Cod_Model_Cod|null)
     * @author NetGo
     */
    public function getCurrentCod()
    {
        return Mage::registry('current_cod');
    } 
}

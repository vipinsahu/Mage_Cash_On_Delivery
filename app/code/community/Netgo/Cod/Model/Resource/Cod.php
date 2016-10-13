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
class Netgo_Cod_Model_Resource_Cod extends Mage_Core_Model_Resource_Db_Abstract
{

    /**
     * constructor
     *
     * @access public
     * @author NetGo
     */
    public function _construct()
    {
        $this->_init('netgo_cod/cod', 'entity_id');
    }
}

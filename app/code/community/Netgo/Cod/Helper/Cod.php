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
class Netgo_Cod_Helper_Cod extends Mage_Core_Helper_Abstract
{

    /**
     * check if breadcrumbs can be used
     *
     * @access public
     * @return bool
     * @author NetGo
     */
    public function getUseBreadcrumbs()
    {
        return Mage::getStoreConfigFlag('netgo_cod/cod/breadcrumbs');
    }

    /**
     * get base files dir
     *
     * @access public
     * @return string
     * @author NetGo
     */
    public function getFileBaseDir()
    {
        return Mage::getBaseDir('media').DS.'cod'.DS.'file';
    }

    /**
     * get base file url
     *
     * @access public
     * @return string
     * @author NetGo
     */
    public function getFileBaseUrl()
    {
        return Mage::getBaseUrl('media').'cod'.'/'.'file';
    }
}

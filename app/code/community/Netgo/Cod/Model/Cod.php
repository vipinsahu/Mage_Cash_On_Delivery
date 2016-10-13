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
class Netgo_Cod_Model_Cod extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'netgo_cod_cod';
    const CACHE_TAG = 'netgo_cod_cod';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'netgo_cod_cod';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'cod';

    /**
     * constructor
     *
     * @access public
     * @return void
     * @author NetGo
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('netgo_cod/cod');
    }

    /**
     * before save cod
     *
     * @access protected
     * @return Netgo_Cod_Model_Cod
     * @author NetGo
     */
    protected function _beforeSave()
    {
        parent::_beforeSave();
        $now = Mage::getSingleton('core/date')->gmtDate();
        if ($this->isObjectNew()) {
            $this->setCreatedAt($now);
        }
        $this->setUpdatedAt($now);
        return $this;
    }

    /**
     * get the url to the cod details page
     *
     * @access public
     * @return string
     * @author NetGo
     */
    public function getCodUrl()
    {
        return Mage::getUrl('netgo_cod/cod/view', array('id'=>$this->getId()));
    }

    /**
     * save cod relation
     *
     * @access public
     * @return Netgo_Cod_Model_Cod
     * @author NetGo
     */
    protected function _afterSave()
    {
        return parent::_afterSave();
    }

    /**
     * get default values
     *
     * @access public
     * @return array
     * @author NetGo
     */
    public function getDefaultValues()
    {
        $values = array();
        $values['status'] = 1;
        return $values;
    }
    
}

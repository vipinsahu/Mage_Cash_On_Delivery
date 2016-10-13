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
 * Socialfeed admin grid block
 *
 * @category    Netgo
 * @package     Netgo_Socialfeeds
 * @author      Ultimate Module Creator
 */
class Netgo_Socialfeeds_Block_Adminhtml_Socialfeed_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * constructor
     *
     * @access public
     * @author Ultimate Module Creator
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('socialfeedGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return Netgo_Socialfeeds_Block_Adminhtml_Socialfeed_Grid
     * @author Ultimate Module Creator
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('netgo_socialfeeds/socialfeed')
            ->getCollection();
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return Netgo_Socialfeeds_Block_Adminhtml_Socialfeed_Grid
     * @author Ultimate Module Creator
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'entity_id',
            array(
                'header' => Mage::helper('netgo_socialfeeds')->__('Id'),
                'index'  => 'entity_id',
                'type'   => 'number'
            )
        );
        $this->addColumn(
            'socialfeeds_status',
            array(
                'header'    => Mage::helper('netgo_socialfeeds')->__('Socialfeeds Status'),
                'align'     => 'left',
                'index'     => 'socialfeeds_status',
            )
        );
        
        $this->addColumn(
            'status',
            array(
                'header'  => Mage::helper('netgo_socialfeeds')->__('Status'),
                'index'   => 'status',
                'type'    => 'options',
                'options' => array(
                    '1' => Mage::helper('netgo_socialfeeds')->__('Enabled'),
                    '0' => Mage::helper('netgo_socialfeeds')->__('Disabled'),
                )
            )
        );
        $this->addColumn(
            'url_key',
            array(
                'header' => Mage::helper('netgo_socialfeeds')->__('URL key'),
                'index'  => 'url_key',
            )
        );
        $this->addColumn(
            'action',
            array(
                'header'  =>  Mage::helper('netgo_socialfeeds')->__('Action'),
                'width'   => '100',
                'type'    => 'action',
                'getter'  => 'getId',
                'actions' => array(
                    array(
                        'caption' => Mage::helper('netgo_socialfeeds')->__('Edit'),
                        'url'     => array('base'=> '*/*/edit'),
                        'field'   => 'id'
                    )
                ),
                'filter'    => false,
                'is_system' => true,
                'sortable'  => false,
            )
        );
        $this->addExportType('*/*/exportCsv', Mage::helper('netgo_socialfeeds')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('netgo_socialfeeds')->__('Excel'));
        $this->addExportType('*/*/exportXml', Mage::helper('netgo_socialfeeds')->__('XML'));
        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return Netgo_Socialfeeds_Block_Adminhtml_Socialfeed_Grid
     * @author Ultimate Module Creator
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('socialfeed');
        $this->getMassactionBlock()->addItem(
            'delete',
            array(
                'label'=> Mage::helper('netgo_socialfeeds')->__('Delete'),
                'url'  => $this->getUrl('*/*/massDelete'),
                'confirm'  => Mage::helper('netgo_socialfeeds')->__('Are you sure?')
            )
        );
        $this->getMassactionBlock()->addItem(
            'status',
            array(
                'label'      => Mage::helper('netgo_socialfeeds')->__('Change status'),
                'url'        => $this->getUrl('*/*/massStatus', array('_current'=>true)),
                'additional' => array(
                    'status' => array(
                        'name'   => 'status',
                        'type'   => 'select',
                        'class'  => 'required-entry',
                        'label'  => Mage::helper('netgo_socialfeeds')->__('Status'),
                        'values' => array(
                            '1' => Mage::helper('netgo_socialfeeds')->__('Enabled'),
                            '0' => Mage::helper('netgo_socialfeeds')->__('Disabled'),
                        )
                    )
                )
            )
        );
        return $this;
    }

    /**
     * get the row url
     *
     * @access public
     * @param Netgo_Socialfeeds_Model_Socialfeed
     * @return string
     * @author Ultimate Module Creator
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

    /**
     * get the grid url
     *
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }

    /**
     * after collection load
     *
     * @access protected
     * @return Netgo_Socialfeeds_Block_Adminhtml_Socialfeed_Grid
     * @author Ultimate Module Creator
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
}

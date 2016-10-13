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
class Netgo_Cod_Adminhtml_Cod_CodController extends Netgo_Cod_Controller_Adminhtml_Cod
{
    /**
     * init the cod
     *
     * @access protected
     * @return Netgo_Cod_Model_Cod
     */
    protected function _initCod()
    {
        $codId  = (int) $this->getRequest()->getParam('id');
        $cod    = Mage::getModel('netgo_cod/cod');
        if ($codId) {
            $cod->load($codId);
        }
        Mage::register('current_cod', $cod);
        return $cod;
    }

    /**
     * default action
     *
     * @access public
     * @return void
     * @author NetGo
     */
    public function indexAction()
    {
        $this->loadLayout();
        $this->_title(Mage::helper('netgo_cod')->__('Manage COD'))
             ->_title(Mage::helper('netgo_cod')->__('CODS'));
        $this->renderLayout();
    }

    /**
     * grid action
     *
     * @access public
     * @return void
     * @author NetGo
     */
    public function gridAction()
    {
        $this->loadLayout()->renderLayout();
    }

    /**
     * edit cod - action
     *
     * @access public
     * @return void
     * @author NetGo
     */
    public function editAction()
    {
        $codId    = $this->getRequest()->getParam('id');
        $cod      = $this->_initCod();
        if ($codId && !$cod->getId()) {
            $this->_getSession()->addError(
                Mage::helper('netgo_cod')->__('This cod no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getCodData(true);
        if (!empty($data)) {
            $cod->setData($data);
        }
        Mage::register('cod_data', $cod);
        $this->loadLayout();
        $this->_title(Mage::helper('netgo_cod')->__('Manage COD'))
             ->_title(Mage::helper('netgo_cod')->__('CODS'));
        if ($cod->getId()) {
            $this->_title($cod->getZipcode());
        } else {
            $this->_title(Mage::helper('netgo_cod')->__('Add cod'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new cod action
     *
     * @access public
     * @return void
     * @author NetGo
     */
    public function newAction()
    {
        $this->_forward('edit');
    }

    /**
     * save cod - action
     *
     * @access public
     * @return void
     * @author NetGo
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('cod')) {
            try {
				
				
				
                $cod = $this->_initCod();
                $cod->addData($data);
                $csvfileName = $this->_uploadAndGetName(
                    'csvfile',
                    Mage::helper('netgo_cod/cod')->getFileBaseDir(),
                    $data
                ); 
                //$cod->setData('csvfile', $csvfileName);
				
				$file_handle = fopen(Mage::getBaseDir('media') . DS . 'cod' . DS . 'file' . DS . $csvfileName, "r");
				
				while (!feof($file_handle) ) {
					$row = fgetcsv($file_handle, 1024);  
					 
					if($row[0] != 'zipcode'){
						$codObj = Mage::getModel('netgo_cod/cod')->getCollection()->addFieldToFilter('zipcode', $row[0]);
						$codData = $codObj->getData();
						
						$codObject = Mage::getModel('netgo_cod/cod');  
						if(count($codObj->getData()) > 0){
							$codObject->setEntityId($codData[0]['entity_id']); 
							$codObject->setZipcode($row[0]); 
							$codObject->setStatus($row[1]);
							$codObject->setDays($row[2]);
							 
							$codObject->save();
						}else{
							if($row[0] != ''){
								$codObject->setZipcode($row[0]); 
								$codObject->setStatus($row[1]);
								$codObject->setDays($row[2]);
								$codObject->save();
							}
						} 
					}  
				}
				//print_r($data);die;
				fclose($file_handle); 
				if($data['zipcode'] != ''){
					$cod->save(); 
				} 
                //$cod->save();
				//return;
				
				
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('netgo_cod')->__('COD was successfully saved')
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $cod->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                if (isset($data['csvfile']['value'])) {
                    $data['csvfile'] = $data['csvfile']['value'];
                }
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setCodData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                if (isset($data['csvfile']['value'])) {
                    $data['csvfile'] = $data['csvfile']['value'];
                }
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('netgo_cod')->__('There was a problem saving the cod.')
                );
                Mage::getSingleton('adminhtml/session')->setCodData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('netgo_cod')->__('Unable to find cod to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete cod - action
     *
     * @access public
     * @return void
     * @author NetGo
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $cod = Mage::getModel('netgo_cod/cod');
                $cod->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('netgo_cod')->__('COD was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('netgo_cod')->__('There was an error deleting cod.')
                );
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('netgo_cod')->__('Could not find cod to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete cod - action
     *
     * @access public
     * @return void
     * @author NetGo
     */
    public function massDeleteAction()
    {
        $codIds = $this->getRequest()->getParam('cod');
        if (!is_array($codIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('netgo_cod')->__('Please select cods to delete.')
            );
        } else {
            try {
                foreach ($codIds as $codId) {
                    $cod = Mage::getModel('netgo_cod/cod');
                    $cod->setId($codId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('netgo_cod')->__('Total of %d cods were successfully deleted.', count($codIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('netgo_cod')->__('There was an error deleting cods.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass status change - action
     *
     * @access public
     * @return void
     * @author NetGo
     */
    public function massStatusAction()
    {
        $codIds = $this->getRequest()->getParam('cod');
        if (!is_array($codIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('netgo_cod')->__('Please select cods.')
            );
        } else {
            try {
                foreach ($codIds as $codId) {
                $cod = Mage::getSingleton('netgo_cod/cod')->load($codId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d cods were successfully updated.', count($codIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('netgo_cod')->__('There was an error updating cods.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * export as csv - action
     *
     * @access public
     * @return void
     * @author NetGo
     */
    public function exportCsvAction()
    {
        $fileName   = 'cod.csv';
        $content    = $this->getLayout()->createBlock('netgo_cod/adminhtml_cod_grid')
            ->getCsv();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * export as MsExcel - action
     *
     * @access public
     * @return void
     * @author NetGo
     */
    public function exportExcelAction()
    {
        $fileName   = 'cod.xls';
        $content    = $this->getLayout()->createBlock('netgo_cod/adminhtml_cod_grid')
            ->getExcelFile();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * export as xml - action
     *
     * @access public
     * @return void
     * @author NetGo
     */
    public function exportXmlAction()
    {
        $fileName   = 'cod.xml';
        $content    = $this->getLayout()->createBlock('netgo_cod/adminhtml_cod_grid')
            ->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * Check if admin has permissions to visit related pages
     *
     * @access protected
     * @return boolean
     * @author NetGo
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('netgo_cod/cod');
    }
}

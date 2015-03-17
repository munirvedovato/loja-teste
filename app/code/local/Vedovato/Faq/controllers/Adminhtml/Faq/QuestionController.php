<?php
/**
 * Vedovato_Faq extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       Vedovato
 * @package        Vedovato_Faq
 * @copyright      Copyright (c) 2015
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Question admin controller
 *
 * @category    Vedovato
 * @package     Vedovato_Faq
 * @author      Ultimate Module Creator
 */
class Vedovato_Faq_Adminhtml_Faq_QuestionController extends Vedovato_Faq_Controller_Adminhtml_Faq
{
    /**
     * init the question
     *
     * @access protected
     * @return Vedovato_Faq_Model_Question
     */
    protected function _initQuestion()
    {
        $questionId  = (int) $this->getRequest()->getParam('id');
        $question    = Mage::getModel('vedovato_faq/question');
        if ($questionId) {
            $question->load($questionId);
        }
        Mage::register('current_question', $question);
        return $question;
    }

    /**
     * default action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function indexAction()
    {
        $this->loadLayout();
        $this->_title(Mage::helper('vedovato_faq')->__('Perguntas Frequentes'))
             ->_title(Mage::helper('vedovato_faq')->__('Questions'));
        $this->renderLayout();
    }

    /**
     * grid action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function gridAction()
    {
        $this->loadLayout()->renderLayout();
    }

    /**
     * edit question - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function editAction()
    {
        $questionId    = $this->getRequest()->getParam('id');
        $question      = $this->_initQuestion();
        if ($questionId && !$question->getId()) {
            $this->_getSession()->addError(
                Mage::helper('vedovato_faq')->__('This question no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getQuestionData(true);
        if (!empty($data)) {
            $question->setData($data);
        }
        Mage::register('question_data', $question);
        $this->loadLayout();
        $this->_title(Mage::helper('vedovato_faq')->__('Perguntas Frequentes'))
             ->_title(Mage::helper('vedovato_faq')->__('Questions'));
        if ($question->getId()) {
            $this->_title($question->getPergunta());
        } else {
            $this->_title(Mage::helper('vedovato_faq')->__('Add question'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new question action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function newAction()
    {
        $this->_forward('edit');
    }

    /**
     * save question - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('question')) {
            try {
                $question = $this->_initQuestion();
                $question->addData($data);
                $question->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('vedovato_faq')->__('Question was successfully saved')
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $question->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setQuestionData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('vedovato_faq')->__('There was a problem saving the question.')
                );
                Mage::getSingleton('adminhtml/session')->setQuestionData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('vedovato_faq')->__('Unable to find question to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete question - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $question = Mage::getModel('vedovato_faq/question');
                $question->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('vedovato_faq')->__('Question was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('vedovato_faq')->__('There was an error deleting question.')
                );
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('vedovato_faq')->__('Could not find question to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete question - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function massDeleteAction()
    {
        $questionIds = $this->getRequest()->getParam('question');
        if (!is_array($questionIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('vedovato_faq')->__('Please select questions to delete.')
            );
        } else {
            try {
                foreach ($questionIds as $questionId) {
                    $question = Mage::getModel('vedovato_faq/question');
                    $question->setId($questionId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('vedovato_faq')->__('Total of %d questions were successfully deleted.', count($questionIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('vedovato_faq')->__('There was an error deleting questions.')
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
     * @author Ultimate Module Creator
     */
    public function massStatusAction()
    {
        $questionIds = $this->getRequest()->getParam('question');
        if (!is_array($questionIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('vedovato_faq')->__('Please select questions.')
            );
        } else {
            try {
                foreach ($questionIds as $questionId) {
                $question = Mage::getSingleton('vedovato_faq/question')->load($questionId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d questions were successfully updated.', count($questionIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('vedovato_faq')->__('There was an error updating questions.')
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
     * @author Ultimate Module Creator
     */
    public function exportCsvAction()
    {
        $fileName   = 'question.csv';
        $content    = $this->getLayout()->createBlock('vedovato_faq/adminhtml_question_grid')
            ->getCsv();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * export as MsExcel - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function exportExcelAction()
    {
        $fileName   = 'question.xls';
        $content    = $this->getLayout()->createBlock('vedovato_faq/adminhtml_question_grid')
            ->getExcelFile();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * export as xml - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function exportXmlAction()
    {
        $fileName   = 'question.xml';
        $content    = $this->getLayout()->createBlock('vedovato_faq/adminhtml_question_grid')
            ->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * Check if admin has permissions to visit related pages
     *
     * @access protected
     * @return boolean
     * @author Ultimate Module Creator
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('vedovato_faq/question');
    }
}

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
 * Question front contrller
 *
 * @category    Vedovato
 * @package     Vedovato_Faq
 * @author      Ultimate Module Creator
 */
class Vedovato_Faq_QuestionController extends Mage_Core_Controller_Front_Action
{

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
        $this->_initLayoutMessages('catalog/session');
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('checkout/session');
        if (Mage::helper('vedovato_faq/question')->getUseBreadcrumbs()) {
            if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')) {
                $breadcrumbBlock->addCrumb(
                    'home',
                    array(
                        'label' => Mage::helper('vedovato_faq')->__('Home'),
                        'link'  => Mage::getUrl(),
                    )
                );
                $breadcrumbBlock->addCrumb(
                    'questions',
                    array(
                        'label' => Mage::helper('vedovato_faq')->__('Questions'),
                        'link'  => '',
                    )
                );
            }
        }
        $headBlock = $this->getLayout()->getBlock('head');
        if ($headBlock) {
            $headBlock->addLinkRel('canonical', Mage::helper('vedovato_faq/question')->getQuestionsUrl());
        }
        $this->renderLayout();
    }

    /**
     * init Question
     *
     * @access protected
     * @return Vedovato_Faq_Model_Question
     * @author Ultimate Module Creator
     */
    protected function _initQuestion()
    {
        $questionId   = $this->getRequest()->getParam('id', 0);
        $question     = Mage::getModel('vedovato_faq/question')
            ->setStoreId(Mage::app()->getStore()->getId())
            ->load($questionId);
        if (!$question->getId()) {
            return false;
        } elseif (!$question->getStatus()) {
            return false;
        }
        return $question;
    }

    /**
     * view question action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function viewAction()
    {
        $question = $this->_initQuestion();
        if (!$question) {
            $this->_forward('no-route');
            return;
        }
        Mage::register('current_question', $question);
        $this->loadLayout();
        $this->_initLayoutMessages('catalog/session');
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('checkout/session');
        if ($root = $this->getLayout()->getBlock('root')) {
            $root->addBodyClass('faq-question faq-question' . $question->getId());
        }
        if (Mage::helper('vedovato_faq/question')->getUseBreadcrumbs()) {
            if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')) {
                $breadcrumbBlock->addCrumb(
                    'home',
                    array(
                        'label'    => Mage::helper('vedovato_faq')->__('Home'),
                        'link'     => Mage::getUrl(),
                    )
                );
                $breadcrumbBlock->addCrumb(
                    'questions',
                    array(
                        'label' => Mage::helper('vedovato_faq')->__('Questions'),
                        'link'  => Mage::helper('vedovato_faq/question')->getQuestionsUrl(),
                    )
                );
                $breadcrumbBlock->addCrumb(
                    'question',
                    array(
                        'label' => $question->getPergunta(),
                        'link'  => '',
                    )
                );
            }
        }
        $headBlock = $this->getLayout()->getBlock('head');
        if ($headBlock) {
            $headBlock->addLinkRel('canonical', $question->getQuestionUrl());
        }
        $this->renderLayout();
    }
}

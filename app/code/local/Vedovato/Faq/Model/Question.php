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
 * Question model
 *
 * @category    Vedovato
 * @package     Vedovato_Faq
 * @author      Ultimate Module Creator
 */
class Vedovato_Faq_Model_Question extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'vedovato_faq_question';
    const CACHE_TAG = 'vedovato_faq_question';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'vedovato_faq_question';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'question';

    /**
     * constructor
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('vedovato_faq/question');
    }

    /**
     * before save question
     *
     * @access protected
     * @return Vedovato_Faq_Model_Question
     * @author Ultimate Module Creator
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
     * get the url to the question details page
     *
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
    public function getQuestionUrl()
    {
        return Mage::getUrl('vedovato_faq/question/view', array('id'=>$this->getId()));
    }

    /**
     * get the question Resposta
     *
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
    public function getResposta()
    {
        $resposta = $this->getData('resposta');
        $helper = Mage::helper('cms');
        $processor = $helper->getBlockTemplateProcessor();
        $html = $processor->filter($resposta);
        return $html;
    }

    /**
     * save question relation
     *
     * @access public
     * @return Vedovato_Faq_Model_Question
     * @author Ultimate Module Creator
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
     * @author Ultimate Module Creator
     */
    public function getDefaultValues()
    {
        $values = array();
        $values['status'] = 1;
        return $values;
    }
    
}

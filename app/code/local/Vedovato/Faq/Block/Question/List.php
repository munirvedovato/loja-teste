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
 * Question list block
 *
 * @category    Vedovato
 * @package     Vedovato_Faq
 * @author Ultimate Module Creator
 */
class Vedovato_Faq_Block_Question_List extends Mage_Core_Block_Template
{
    /**
     * initialize
     *
     * @access public
     * @author Ultimate Module Creator
     */
    public function __construct()
    {
        parent::__construct();
        $questions = Mage::getResourceModel('vedovato_faq/question_collection')
                         ->addStoreFilter(Mage::app()->getStore())
                         ->addFieldToFilter('status', 1);
        $questions->setOrder('pergunta', 'asc');
        $this->setQuestions($questions);
    }

    /**
     * prepare the layout
     *
     * @access protected
     * @return Vedovato_Faq_Block_Question_List
     * @author Ultimate Module Creator
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $pager = $this->getLayout()->createBlock(
            'page/html_pager',
            'vedovato_faq.question.html.pager'
        )
        ->setCollection($this->getQuestions());
        $this->setChild('pager', $pager);
        $this->getQuestions()->load();
        return $this;
    }

    /**
     * get the pager html
     *
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }
}

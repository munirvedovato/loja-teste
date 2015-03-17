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
 * Question admin edit tabs
 *
 * @category    Vedovato
 * @package     Vedovato_Faq
 * @author      Ultimate Module Creator
 */
class Vedovato_Faq_Block_Adminhtml_Question_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * Initialize Tabs
     *
     * @access public
     * @author Ultimate Module Creator
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('question_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('vedovato_faq')->__('Question'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return Vedovato_Faq_Block_Adminhtml_Question_Edit_Tabs
     * @author Ultimate Module Creator
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_question',
            array(
                'label'   => Mage::helper('vedovato_faq')->__('Question'),
                'title'   => Mage::helper('vedovato_faq')->__('Question'),
                'content' => $this->getLayout()->createBlock(
                    'vedovato_faq/adminhtml_question_edit_tab_form'
                )
                ->toHtml(),
            )
        );
        if (!Mage::app()->isSingleStoreMode()) {
            $this->addTab(
                'form_store_question',
                array(
                    'label'   => Mage::helper('vedovato_faq')->__('Store views'),
                    'title'   => Mage::helper('vedovato_faq')->__('Store views'),
                    'content' => $this->getLayout()->createBlock(
                        'vedovato_faq/adminhtml_question_edit_tab_stores'
                    )
                    ->toHtml(),
                )
            );
        }
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve question entity
     *
     * @access public
     * @return Vedovato_Faq_Model_Question
     * @author Ultimate Module Creator
     */
    public function getQuestion()
    {
        return Mage::registry('current_question');
    }
}

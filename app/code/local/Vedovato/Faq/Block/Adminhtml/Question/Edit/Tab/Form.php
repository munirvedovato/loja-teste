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
 * Question edit form tab
 *
 * @category    Vedovato
 * @package     Vedovato_Faq
 * @author      Ultimate Module Creator
 */
class Vedovato_Faq_Block_Adminhtml_Question_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return Vedovato_Faq_Block_Adminhtml_Question_Edit_Tab_Form
     * @author Ultimate Module Creator
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('question_');
        $form->setFieldNameSuffix('question');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'question_form',
            array('legend' => Mage::helper('vedovato_faq')->__('Question'))
        );
        $wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig();

        $fieldset->addField(
            'pergunta',
            'text',
            array(
                'label' => Mage::helper('vedovato_faq')->__('Pergunta'),
                'name'  => 'pergunta',
            'required'  => true,
            'class' => 'required-entry',

           )
        );

        $fieldset->addField(
            'resposta',
            'editor',
            array(
                'label' => Mage::helper('vedovato_faq')->__('Resposta'),
                'name'  => 'resposta',
            'config' => $wysiwygConfig,
            'required'  => true,
            'class' => 'required-entry',

           )
        );
        $fieldset->addField(
            'status',
            'select',
            array(
                'label'  => Mage::helper('vedovato_faq')->__('Status'),
                'name'   => 'status',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('vedovato_faq')->__('Enabled'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('vedovato_faq')->__('Disabled'),
                    ),
                ),
            )
        );
        if (Mage::app()->isSingleStoreMode()) {
            $fieldset->addField(
                'store_id',
                'hidden',
                array(
                    'name'      => 'stores[]',
                    'value'     => Mage::app()->getStore(true)->getId()
                )
            );
            Mage::registry('current_question')->setStoreId(Mage::app()->getStore(true)->getId());
        }
        $formValues = Mage::registry('current_question')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getQuestionData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getQuestionData());
            Mage::getSingleton('adminhtml/session')->setQuestionData(null);
        } elseif (Mage::registry('current_question')) {
            $formValues = array_merge($formValues, Mage::registry('current_question')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}

<?php

namespace Drupal\ajase\Form;

use Drupal\Core\Ajax\InvokeCommand;
use Drupal\Core\Ajax\RedirectCommand;
use Drupal\Core\Ajax\RestripeCommand;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;

class FieldForm extends FormBase
{
    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'field_form';
    }

    /**
     * @param array $form
     * @param FormStateInterface $form_state
     * @return array
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $form['latitude'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('latitude'),
            '#ajax' => [
                'callback' => '::ajaxChangeMap',
                'event' => 'change',
                'progress' => [
                    'type' => 'throbber',
                    'message' => 'Getting some things...',
                ],
            ],
        );
        $form['longitude'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('longitude'),
            '#ajax' => [
                'callback' => '::ajaxChangeMap',
                'event' => 'change',
                'progress' => [
                    'type' => 'throbber',
                    'message' => 'Getting some things...',
                ],
            ],
        );
        $form['save'] = array(
            '#type' => 'submit',
            '#value' => $this->t('Save'),
            '#ajax' => [
                'callback' => '::ajaxAddRecord',
                'event' => 'click',
                'progress' => [
                    'type' => 'throbber',
                    'message' => 'Getting some things...',
                ],
            ],
        );

        return $form;
    }

    public function ajaxChangeMap(array &$form, FormStateInterface $form_state)
    {
        $ajax_response = new AjaxResponse();

        $ajax_response->addCommand(new InvokeCommand(NULL, 'changeMap', [$form_state->getValue('latitude'),  $form_state->getValue('longitude')] ));

        return $ajax_response;
    }

    public function ajaxAddRecord(array &$form, FormStateInterface $form_state)
    {
        $ajax_response = new AjaxResponse();

        $db_logic = \Drupal::service('ajase.db_logic');
        $latitude = $form_state->getValue('latitude');
        $longitude= $form_state->getValue('longitude');

        $db_logic->add($latitude, $longitude);

        $response = $db_logic->getAll();

        $ajax_response->addCommand(new InvokeCommand(NULL, 'reloadTable', [$response]));
        //$ajax_response->addCommand(new RestripeCommand('reloadTable'));

        return $ajax_response;
    }

    /**
     * @param array $form
     * @param FormStateInterface $form_state
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
//        $db_logic = \Drupal::service('ajase.db_logic');
//        $latitude = $form_state->getValue('latitude');
//        $longitude= $form_state->getValue('longitude');
//
//        $db_logic->add($latitude, $longitude);

//        return parent::submitForm($form, $form_state);
    }
}
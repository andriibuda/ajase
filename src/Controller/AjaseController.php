<?php

namespace Drupal\ajase\Controller;

use Drupal\Core\Controller\ControllerBase;

class AjaseController extends ControllerBase
{
    public function main()
    {
        $form = \Drupal::formBuilder()->getForm('Drupal\ajase\Form\FieldForm');
        $name = \Drupal::config('system.site')->get('name');
        $db_logic = \Drupal::service('ajase.db_logic');
        $list = $db_logic->getAll();

        $page = array(
            '#title' => 'Ajase',
            '#theme' => 'ajase',
            '#form' => $form,
            '#name' => $name,
            '#list' => $list,
        );

        return $page;
    }
}
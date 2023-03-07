<?php
/**
 * @file
 * Contains \Drupal\form_module\Form\PersonForm
 */
namespace Drupal\form_module\Form;

use Drupal\Core\Database\Database;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Add person form.
 */
class PersonForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'person_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = array();

    $form['message'] = array(
      '#markup' => $this->t('Add data related to a person.'),
    );

    $form['firstname'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('First name'),
      '#size' => 15,
    );
    $form['lastname'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Last name'),
      '#size' => 15,
    );
    $form['age'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Age'),
      '#size' => 5,
    );
    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Add person'),
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // Confirm that age is numeric.
    if (!intval($form_state->getValue('age'))) {
      $form_state->setErrorByName('age', $this->t('Age needs to be a number'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Obtain values as entered into the Form. 
    $first_name = $form_state->getValue('firstname');
    $last_name = $form_state->getValue('lastname');
    $age = $form_state->getValue('age');

    $query = \Drupal::database()->insert('form_module');

    $query->fields([
      'firstname',
      'lastname',
      'age',
    ]);

    $query->values([
      $first_name,
      $last_name,
      $age,
    ]);

    $query->execute();
  }
}

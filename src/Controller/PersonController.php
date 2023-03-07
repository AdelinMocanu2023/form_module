<?php
/**
 * @file
 * Contains \Drupal\form_module\Controller\PersonController.
 */
namespace Drupal\form_module\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;

/**
 * Controller for person page.
 */
class PersonController extends ControllerBase {

  /**
   * @return array
   */
  public function load() {
    // Read all the fields from the form_module table.
    $select = Database::getConnection()
      ->select('form_module')
      // Add all the fields into select query.
      ->fields('form_module');

    $entries = $select->execute()->fetchAll();
    return $entries;
  }

  public function page() {
    $content = array();

    $content['message'] = array(
      '#markup' => $this->t('Data of a person'),
    );
    $headers = array(
      t('firstname'),
      t('lastname'),
      t('age'),
    );
    $rows = array();
    foreach ($entries = $this->load() as $entry) {
      // Sanitize each entry.
      $rows[] = array_map('Drupal\Component\Utility\Html::escape', (array) $entry);
    }
    $content['table'] = array(
      '#type' => 'table',
      '#header' => $headers,
      '#rows' => $rows,
    );
    // Don't cache this page.
    $content['#cache']['max-age'] = 0;
    return $content;
  }

}

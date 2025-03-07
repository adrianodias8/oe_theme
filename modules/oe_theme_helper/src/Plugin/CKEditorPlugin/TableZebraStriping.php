<?php

declare(strict_types = 1);

namespace Drupal\oe_theme_helper\Plugin\CKEditorPlugin;

use Drupal\ckeditor\CKEditorPluginBase;
use Drupal\ckeditor\CKEditorPluginContextualInterface;
use Drupal\editor\Entity\Editor;

/**
 * Defines the "table_zebra_striping" with altering Table plugins.
 *
 * @CKEditorPlugin(
 *   id = "table_zebra_striping",
 *   label = @Translation("Zebra striping")
 * )
 */
class TableZebraStriping extends CKEditorPluginBase implements CKEditorPluginContextualInterface {

  /**
   * {@inheritdoc}
   */
  public function getFile() {
    return $this->getModulePath('oe_theme_helper') . '/js/table_zebra_striping.js';
  }

  /**
   * {@inheritdoc}
   */
  public function getConfig(Editor $editor) {
    return [
      'zebra_striping__checkboxLabel' => $this->t('Zebra striping'),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getButtons() {
    return [];
  }

  /**
   * {@inheritdoc}
   */
  public function isEnabled(Editor $editor) {
    if (!$editor->hasAssociatedFilterFormat()) {
      return FALSE;
    }

    // "Zebra striping" option should be available only when the ECL table
    // filter is enabled and the table button is present in the WYSIWYG toolbar.
    $enabled = FALSE;
    $format = $editor->getFilterFormat();
    if ($format->filters('filter_ecl_table')->status) {
      $settings = $editor->getSettings();
      foreach ($settings['toolbar']['rows'] as $row) {
        foreach ($row as $group) {
          foreach ($group['items'] as $button) {
            if ($button === 'Table') {
              $enabled = TRUE;
            }
          }
        }
      }
    }

    return $enabled;
  }

}

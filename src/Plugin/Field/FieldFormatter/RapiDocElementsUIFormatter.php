<?php

namespace Drupal\rapidoc_elements_field_formatter\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Plugin\Field\FieldFormatter\FileFormatterBase;

/**
 * Plugin implementation of the 'rapidoc_elements_ui' formatter.
 *
 * @FieldFormatter(
 *   id = "rapidoc_elements_ui",
 *   label = @Translation("RapiDoc Elements UI"),
 *   description = @Translation("Formats file fields with RapiDoc Elements YAML or JSON
 *   files with a rendered RapiDoc Elements UI"), field_types = {
 *     "file"
 *   }
 * )
 */
class RapiDocElementsUIFormatter extends FileFormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $form = parent::settingsForm($form, $form_state);
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = parent::settingsSummary();
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function view(FieldItemListInterface $items, $langcode = NULL) {
    $elements = parent::view($items, $langcode);
    $elements['#attached']['library'][] = 'rapidoc_elements_field_formatter/rapidoc_elements_field_formatter.rapidoc';
    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = [];
    foreach ($this->getEntitiesToView($items, $langcode) as $delta => $file) {
      $rapidoc_file = file_create_url($file->getFileUri());
      $element[$delta] = [
        '#theme' => 'rapidoc_elements_ui_field_item',
        '#field_name' => $this->fieldDefinition->getName(),
        '#entity' => $items->getEntity(),
        '#delta' => $delta,
        '#file_url' => $rapidoc_file,
      ];
    }
    return $element;
  }

}

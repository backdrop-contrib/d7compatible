<?php
/**
 * @file
 * MyTheme preprocess functions and theme function overrides.
 */

/*******************************************************************************
 * Preprocess functions
 ******************************************************************************/

/**
 * Prepares variables for page templates.
 *
 * @see page.tpl.php and derivatives.
 */
function d7compatible_preprocess_page(&$variables) {
  // Add unique and section-based classes for each page.
  $path = backdrop_get_path_alias($_GET['q']);
  $unique_class = d7compatible_id_safe('page-' . $path);
  $section_class = d7compatible_id_safe('page-' . arg(0));
  if ($section_class != $unique_class) {
    $variables['classes'][] = $section_class;
  }
  $variables['classes'][] = $unique_class;

  // Add back legacy front/not-front classes.
  if ($variables['is_front']) {
    $variables['classes'][] = 'front';
  }
  else {
    $variables['classes'][] = 'not-front';
  }
}

/**
 * Prepares variables for node templates.
 *
 * @see node.tpl.php and derivatives.
 */
function d7compatible_preprocess_node(&$variables) {
  // Restore the legacy node ID as the css ID.
  $variables['attributes']['id'] = 'node-' . $variables['node']->nid;

  // Restore classes and attributes to strings.
  $variables['classes'] = implode(' ', $variables['classes']);

  // Restore attributes to strings.
  d7compatible_attributes_convert($variables['attributes']);
  //d7compatible_attributes_convert($variables['title_attributes']);
  d7compatible_attributes_convert($variables['content_attributes']);

  // Restore legacy `node-teaser` class.
  if ($variables['view_mode'] == 'teaser') {
    $variables['theme_hook_suggestions'][] = 'node__resource__teaser';
    $variables['classes'][] = 'node-teaser';      
  }

  // Add more template suggestions based on view mode.
  if (!in_array($variables['view_mode'], array('full', 'teaser'))) {
    $last = array_pop($variables['theme_hook_suggestions']);
    $start = 'node__';
    $view_mode = $variables['view_mode'];
    $type = $variables['node']->type;
    $variables['theme_hook_suggestions'][] = $start . $view_mode;
    $variables['theme_hook_suggestions'][] = $start . $type . '__'. $view_mode;
    $variables['theme_hook_suggestions'][] = $last;
  }
}

/**
 * Prepare vairables for block templates.
 *
 * @see block.tpl.php and derivatives.
 */
function d7compatible_preprocess_block(&$variables) {
  // Restore Drupal-7-style block-title class.
  $variables['title_attributes']['class'][] = 'block-title';

  // Restore Drupal-7-style legacy block ID.
  $block = $variables['block'];
  $block_class = backdrop_html_class('block-' . $block->module . '-' . (isset($block->childDelta) ? $block->childDelta : $block->delta));
  $old_block_class = str_replace('--', '-', $block_class);
  $variables['attributes']['id'] = $old_block_class;

  $variables['header_menu'] = FALSE;
  // Add the ID to the main menu block in the header.
  if ($block->module == 'system' && $block->delta == 'main-menu') {
    // Check the menu style to determine which is the header menu.
    if (isset($block->settings['block_settings']['style']) && $block->settings['block_settings']['style'] == 'top_only') {
      $variables['attributes']['id'] = 'navigation';
      $variables['header_menu'] = TRUE;
    }
  }

  // Restore classes to strings.
  $variables['classes'] = implode(' ', $variables['classes']);

  // Restore attributes to strings.
  d7compatible_attributes_convert($variables['attributes']);
  d7compatible_attributes_convert($variables['title_attributes']);
  d7compatible_attributes_convert($variables['content_attributes']);
}

/**
 * Prepares variables for node templates.
 *
 * @see field.tpl.php and derivatives.
 */
function d7compatible_preprocess_field(&$variables) {
  // Restore classes to strings.
  $variables['classes'] = implode(' ', $variables['classes']);

  // Restore attributes to strings.
  d7compatible_attributes_convert($variables['attributes']);
  d7compatible_attributes_convert($variables['title_attributes']);
  d7compatible_attributes_convert($variables['content_attributes']);

  // Restore field item attributes to strings.
  foreach ($variables['item_attributes'] as $delta => $item_attributes) {
    d7compatible_attributes_convert($variables['item_attributes'][$delta]);
  }
}

/**
 * Overrides theme_menu_tree().
 */
function d7compatible_preprocess_menu_tree(&$variables) {
  $links = element_children($variables['#tree']);
  $first_key = reset($links);

  // Add the ID `main-menu-links` to the UL tag for the main menu.
  if ($variables['#tree'][$first_key]['#theme'] == 'menu_link__main_menu') {
    $variables['attributes']['id'] = 'main-menu-links';
  }
}

/*******************************************************************************
 * Theme functions
 ******************************************************************************/

/**
 * Overrides theme_breadcrumb().
 */
function d7compatible_breadcrumb($variables) {
  $breadcrumb = $variables['breadcrumb'];
  $output = '';

  if (!empty($breadcrumb)) {
    // Add useful aria-label for screen-readers.
    $output .= '<nav role="navigation" class="breadcrumb" aria-label="Website Orientation">';

    // Remove core's confusing you-are-here heading for screen-readers.
    $output .= '<ol><li>' . implode(' » </li><li>', $breadcrumb) . '</li></ol>';
    $output .= '</nav>';
  }

  return $output;
}

/*******************************************************************************
 * Helper functions
 ******************************************************************************/

/**
 * Helper function to restore attributes to strings.
 * 
 * @param array $attributes
 *   Array of attributes common to Backdrop.
 * 
 * @return string
 *   String of attributes as expected by Drupal.
 */
function d7compatible_attributes_convert(&$attributes = array()) {
  if (!empty($attributes)) {
    $attributes = backdrop_attributes($attributes);
  }
  else {
    $attributes = '';
  }
}

/**
 * Helper function to create a HTML ID from any string.
 */
function d7compatible_id_safe($string) {
  // Replace with dashes anything that isn't A-Z, numbers, dashes, or underscores.
  return strtolower(preg_replace('/[^a-zA-Z0-9-]+/', '-', $string));
}
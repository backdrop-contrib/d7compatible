<?php
/**
 * @file
 * MyTheme preprocess functions and theme function overrides.
 */

/**
 * Prepares variables for node templates.
 *
 * @see node.tpl.php
 */
function mytheme_preprocess_node(&$variables) {
  $variables['classes'][] = 'content';
}

/**
 * Overrides theme_breadcrumb().
 */
function mytheme_breadcrumb($variables) {
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

<?php
// This file is part of The Bootstrap 3 Moodle theme
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.


/**
 * Renderers to align Moodle's HTML with that expected by Bootstrap
 *
 * @package    theme_edgy
 * @copyright  2014 Waterford Institute of Technology
 * @authors    Cathal O'Riordan - based on Bootstrap 3 theme by Bas Brands, David Scotson
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Parses CSS before it is cached.
 *
 * This function can make alterations and replace patterns within the CSS.
 *
 * @param string $css The CSS
 * @param theme_config $theme The theme config object.
 * @return string The parsed CSS The parsed CSS.
 */
function theme_edgy_process_css($css, $theme) {

    $settings = get_object_vars($theme->settings);

    $css = theme_edgy_delete_css($settings, $css);

    $settings['brandcss'] = theme_edgy_brand_font_css($settings);

    return theme_edgy_replace_settings($settings, $css);
}

function theme_edgy_delete_css($settings, $css) {
    if ($settings['deletecss'] == true) {
        $find[] = '/-webkit-border-radius:[^;]*;/';
        $find[] = '/-webkit-box-shadow:[^;]*;/';
        $find[] = '/-moz-border-radius:[^;]*;/';
        $find[] = '/-moz-box-shadow:[^;]*;/';
        return preg_replace($find, '', $css);
    } else {
        return $css;
    }
}

/**
 * For each setting called e.g. "customcss" this looks for the string
 * "[[setting:customcss]]" in the CSS and replaces it with
 * the value held in the $settings array for the key
 * "customcss".
 *
 * @param array $settings containing setting names and values
 * @param string $css The CSS
 * @return string The CSS with replacements made
 */
function theme_edgy_replace_settings($settings, $css) {
    foreach ($settings as $name => $value) {
        $find[] = "[[setting:$name]]";
        $replace[] = $value;
    }
    return str_replace($find, $replace, $css);
}

function theme_edgy_brand_font_css($settings) {
    $fontname = $settings['brandfont'];
    if ($fontname === '') {
        return '';
    }
    $fontweight = $settings['brandfontweight'];
    return ".navbar-default .navbar-brand,
            .navbar-inverse .navbar-brand {
                font-family: $fontname, serif;
                font-weight: $fontweight;
            }";
}

/**
 * This function creates the dynamic HTML needed for the 
 * layout and then passes it back in an object so it can
 * be echo'd to the page.
 *
 * This keeps the logic out of the layout files.
 */
function theme_edgy_html_for_settings($PAGE) {
    $settings = $PAGE->theme->settings;

    $html = new stdClass;

    if ($settings->inversenavbar == true) {
        $html->navbarclass = 'navbar navbar-inverse';
    } else {
        $html->navbarclass = 'navbar navbar-default';
    }

    $fluid = (!empty($PAGE->layout_options['fluid']));
    if ($fluid || $settings->fluidwidth == true) {
        $html->containerclass = 'container-fluid';
    } else {
        $html->containerclass = 'container';
    }

    $html->brandfontlink = theme_edgy_brand_font_link($settings);

    return $html;
}

function theme_edgy_brand_font_link($settings) {
    global $SITE;
    $fontname = $settings->brandfont;
    if ($fontname === '') {
        return '';
    }
    $fontname = urlencode($fontname);
    $text = urlencode(str_replace(' ', '', $SITE->shortname));
    $fontweight = $settings->brandfontweight;
    $fontitalic = '';
    if ($settings->brandfontitalic == true) {
        $fontitalic = 'italic';
    }
    return '<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family='
            .$fontname.':'.$fontweight.$fontitalic.'&amp;text='.$text.'">';
}

function edgy_grid($hassidepre, $hassidepost) {
    if ($hassidepre && $hassidepost) {
        $regions = array('content' => 'col-sm-4 col-sm-push-4 col-md-6 col-md-push-3');
        $regions['pre'] = 'col-sm-4 col-sm-pull-4 col-md-3 col-md-pull-6';
        $regions['post'] = 'col-sm-4 col-md-3';
    } else if ($hassidepre && !$hassidepost) {
        $regions = array('content' => 'col-sm-8 col-sm-push-4 col-md-9 col-md-push-3');
        $regions['pre'] = 'col-sm-4 col-sm-pull-8 col-md-3 col-md-pull-9';
        $regions['post'] = 'emtpy';
    } else if (!$hassidepre && $hassidepost) {
        $regions = array('content' => 'col-sm-8 col-md-9');
        $regions['pre'] = 'empty';
        $regions['post'] = 'col-sm-4 col-md-3';
    } else if (!$hassidepre && !$hassidepost) {
        $regions = array('content' => 'col-md-12');
        $regions['pre'] = 'empty';
        $regions['post'] = 'empty';
    }
    return $regions;
}

function theme_edgy_initialise_reader(moodle_page $page) {
    $page->requires->yui_module('moodle-theme_bootstrap-reader', 'M.theme_bootstrap.initreader', array());
}

/**
 * Prints form with a dropdown list of courses, which when submitted, views the selected course
 *
 * @param array $courses - courses to be included in the dropdown list
 */
function print_goto_course_form($courses, $formid, $prompt, $return=false) {
    global $CFG, $USER, $OUTPUT;;
    
    // prepare courses for use in popup_form()
    foreach ($courses as $course) {
        $courses[$course->id] = $course->fullname;
    }
    
    $output = $OUTPUT->single_select(new moodle_url($CFG->wwwroot.'/course/view.php'), 
                                        'id', $courses, '', array('' => $prompt), $formid);   
                                        
    if($return) {
        return $output;
    } else {
        echo $output;
    }
}

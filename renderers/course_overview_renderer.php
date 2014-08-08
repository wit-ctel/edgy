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

include_once($CFG->dirroot . "/blocks/course_overview/renderer.php"); 

class theme_edgy_block_course_overview_renderer extends block_course_overview_renderer {
    
    public function course_overview($courses, $overviews) {
      
      $support_courses = array();
      $registered_courses = array();
      
      // split courses into 'support' or 'registered'
      foreach($courses as $course) {
        if (preg_match("/^SUPPORT_/", $course->idnumber)) {
          $support_courses[$course->id] = $course;
        } else {
          $registered_courses[$course->id] = $course;
        }
      }
      
      // display 'jump to course' dropdown menu
      $html = html_writer::start_tag('div', array('class'=>'well'));
      $html .= html_writer::start_tag('div', array('class'=>'container-fluid', 'id' => 'quickaccess'));
      $html .= html_writer::start_tag('div', array('class'=>'row'));
      $html .= html_writer::start_tag('div', array('class'=>'col-md-6'));
      $html .= html_writer::tag('h4', 'Jump to a Registered module');
      $html .= print_goto_course_form($registered_courses, 'go_to_registered_courses', true);
      $html .= html_writer::end_tag('div');
      
      if (count($support_courses) > 0) {
        $html .= html_writer::start_tag('div', array('class' => 'col-md-6'));
        $html .= html_writer::tag('h4', 'Jump to a Support area');
        $html .= print_goto_course_form($support_courses, 'go_to_support_courses', true);
        $html .= html_writer::end_tag('div');
      }
      $html .= html_writer::end_tag('div');
      $html .= html_writer::end_tag('div');
      $html .= html_writer::end_tag('div');
      
      $html .= parent::course_overview($registered_courses, $overviews);
      
      return $html;
    }     
}
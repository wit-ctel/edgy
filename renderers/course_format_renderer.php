<?php

defined('MOODLE_INTERNAL') || die();

include_once($CFG->dirroot . "/course/format/topics/renderer.php");

class theme_edgy_format_topics_renderer extends format_topics_renderer {
  
  /**
   * Generate next/previous section links for naviation
   *
   * @param stdClass $course The course entry from DB
   * @param array $sections The course_sections entries from the DB
   * @param int $sectionno The section number in the coruse which is being dsiplayed
   * @return array associative array with previous and next section link
   */
  protected function get_nav_links($course, $sections, $sectionno) {
      // FIXME: This is really evil and should by using the navigation API.
      $courseformat = course_get_format($course);
      $previousarrow= '<i class="glyphicon glyphicon-chevron-left"></i>';
      $nextarrow= '<i class="glyphicon glyphicon-chevron-right"></i>';
      $canviewhidden = has_capability('moodle/course:viewhiddensections', context_course::instance($course->id))
          or !$course->hiddensections;

      $links = array('previous' => '', 'next' => '');
      $back = $sectionno - 1;
      while ($back > 0 and empty($links['previous'])) {
          if ($canviewhidden || $sections[$back]->uservisible) {
              $params = array('class' => 'previous_section pull-left');
              if (!$sections[$back]->visible) {
                  $params = array('class' => 'dimmed_text');
              }
              $previouslink = html_writer::start_tag('div', array('class' => 'nav_icon'));
              $previouslink .= $previousarrow;
              $previouslink .= html_writer::end_tag('div');
              $previouslink .= html_writer::start_tag('span', array('class' => 'text'));
              $previouslink .= html_writer::start_tag('span', array('class' => 'nav_guide'));
              $previouslink .= get_string('previoussection', 'theme_edgy');
              $previouslink .= html_writer::end_tag('span');
              $previouslink .= html_writer::empty_tag('br');
              $previouslink .= $courseformat->get_section_name($sections[$back]);
              $previouslink .= html_writer::end_tag('span');
              $links['previous'] = html_writer::link(course_get_url($course, $back), $previouslink, $params);
          }
          $back--;
      }

      $forward = $sectionno + 1;
      while ($forward <= $course->numsections and empty($links['next'])) {
          if ($canviewhidden || $sections[$forward]->uservisible) {
              $params = array('class' => 'next_section pull-right');
              if (!$sections[$forward]->visible) {
                  $params = array('class' => 'dimmed_text');
              }
              $nextlink = html_writer::start_tag('div', array('class' => 'nav_icon'));
              $nextlink .= $nextarrow;
              $nextlink .= html_writer::end_tag('div');
              $nextlink .= html_writer::start_tag('span', array('class' => 'text'));
              $nextlink .= html_writer::start_tag('span', array('class' => 'nav_guide'));
              $nextlink .= get_string('nextsection', 'theme_edgy');
              $nextlink .= html_writer::end_tag('span');
              $nextlink .= html_writer::empty_tag('br');
              $nextlink .= $courseformat->get_section_name($sections[$forward]);
              $nextlink .= html_writer::end_tag('span');
              $links['next'] = html_writer::link(course_get_url($course, $forward), $nextlink, $params);
          }
          $forward++;
      }

      return $links;
  }
  
  public function print_single_section_page($course, $sections, $mods, $modnames, $modnamesused, $displaysection) {
      global $PAGE;

      $modinfo = get_fast_modinfo($course);
      $course = course_get_format($course)->get_course();

      // Can we view the section in question?
      if (!($sectioninfo = $modinfo->get_section_info($displaysection))) {
          // This section doesn't exist
          print_error('unknowncoursesection', 'error', null, $course->fullname);
          return;
      }

      if (!$sectioninfo->uservisible) {
          if (!$course->hiddensections) {
              echo $this->start_section_list();
              echo $this->section_hidden($displaysection);
              echo $this->end_section_list();
          }
          // Can't view this section.
          return;
      }

      // Start single-section div
      echo html_writer::start_tag('div', array('class' => 'section section--single'));

      // The requested section page.
      $thissection = $modinfo->get_section_info($displaysection);

      // Title with section navigation links.
      $sectionnavlinks = $this->get_nav_links($course, $modinfo->get_section_info_all(), $displaysection);
      $sectiontitle = '';
      $sectiontitle .= html_writer::start_tag('div', array('class' => 'section__navigation navigationtitle'));
      $classes = 'sectionname';
      // Title attributes
      $titleattr = 'title';
      if (!$thissection->visible) {
          $titleattr .= ' dimmed_text';
      }
      $sectiontitle .= $this->output->heading(get_section_name($course, $displaysection), 3, $classes);
      $sectiontitle .= html_writer::tag('div', $this->section_nav_selection($course, $sections, $displaysection),
            array('class' => 'pull-right'));
      
      $sectiontitle .= html_writer::end_tag('div');
      echo $sectiontitle;

      // Now the list of sections..
      echo $this->start_section_list();

      echo $this->section_header($thissection, $course, true, $displaysection);
      // Show completion help icon.
      $completioninfo = new completion_info($course);
      echo $completioninfo->display_help_icon();

      echo $this->courserenderer->course_section_cm_list($course, $thissection, $displaysection);
      echo $this->courserenderer->course_section_add_cm_control($course, $displaysection, $displaysection);
      echo $this->section_footer();
      echo $this->end_section_list();

      // Display section bottom navigation.
      $sectionbottomnav = '';
      $sectionbottomnav .= html_writer::start_tag('nav', array('class' => 'section__footer'));
      $sectionbottomnav .= $sectionnavlinks['previous'];
      $sectionbottomnav .= $sectionnavlinks['next'];
      $sectionbottomnav .= html_writer::empty_tag('br', array('style'=>'clear:both'));
      $sectionbottomnav .= html_writer::end_tag('nav');
      echo $sectionbottomnav;

      // Close single-section div.
      echo html_writer::end_tag('div');
  }

}
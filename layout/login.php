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


$hassidepre = false;
$hassidepost = false;

$regions = edgy_grid($hassidepre, $hassidepost);
$PAGE->set_popup_notification_allowed(false);
$PAGE->requires->jquery();
$PAGE->requires->jquery_plugin('bootstrap', 'theme_edgy');
$PAGE->requires->jquery_plugin('edgier', 'theme_edgy');

$settingshtml = theme_edgy_html_for_settings($PAGE);

echo $OUTPUT->doctype() ?>
<html <?php echo $OUTPUT->htmlattributes(); ?>>
<head>
    <title><?php echo $OUTPUT->page_title(); ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->favicon(); ?>" />
    <?php echo $settingshtml->brandfontlink; ?>
    <?php echo $OUTPUT->standard_head_html(); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimal-ui">
</head>

<body <?php echo $OUTPUT->body_attributes(); ?> class="login">
        
    <?php if (preg_match('/^https?:\/\/staging./', $PAGE->url)) { ?>
      <div class="alert alert-warning">
        <p class="text-center">You are using Moodle Staging site</p>
      </div>
    <?php } ?>

    <?php echo $OUTPUT->standard_top_of_body_html() ?>

    <div id="page" class="container">
    
        <div id="page-content" class="row">
          <div id="region-main" class="<?php echo $regions['content']; ?>">
            
            <?php echo $OUTPUT->main_content(); ?>
            <small class="image-attribution">&copy; Image courtesy of Terry Murphy Photography</small>
          </div>
          
          
          <?php
              /* 
                require_once($CFG->dirroot .'/mod/forum/lib.php');

                // need to login 'guest' user to view news items
                $guest = get_complete_user_data('id', $CFG->siteguest);
                complete_user_login($guest);
                $USER->autologinguest = true;

                if (! $newsforum = forum_get_course_forum($SITE->id, 'news')) {
                  print_error('cannotfindorcreateforum', 'forum');
                }

                // fetch news forum context for proper filtering to happen
                $cm = get_coursemodule_from_instance('forum', $newsforum->id, $SITE->id, false, MUST_EXIST);
                        
                $discussions = forum_get_discussions($cm, 'p.modified DESC', true, -1, 1);
        
                if (count($discussions) > 0) {
                    echo html_writer::start_tag('div', array('class' => 'clearfix col-md-8'));
            
                    $strftimerecent = get_string('strftimerecentfull');
                    
                    foreach ($discussions as $discussion) {
                        
                        $discussion_url = $CFG->wwwroot.'/mod/forum/discuss.php?d='.$discussion->discussion;
    
                        echo html_writer::start_tag('article', array('class' => 'announcement'));
                        echo html_writer::start_tag('header');
                        echo html_writer::tag('h4', 
                                  html_writer::link('#announcement-content', $discussion->subject . ' &raquo;', array('class' => 'announcement__link', 'data-toggle' => 'collapse')), 
                                            array('class' => 'announcement__title'));    
                                         
                        echo html_writer::tag('p', 'posted by ' . html_writer::tag('i', fullname($discussion)) . 
                                          ' on ' . html_writer::tag('i', userdate($discussion->modified, $strftimerecent)), 
                                            array('class' => 'announcement__meta'));
                        echo html_writer::end_tag('header');                    
                        echo html_writer::tag('div', $discussion->message, array('class' => 'announcement__body collapse', 'id' => 'announcement-content'));                    
    
                      echo html_writer::end_tag('article');
                  }
          
                  echo html_writer::end_tag('div');
                }
              */
              ?>
      
      </div>
  
    </div> <!-- end #page -->
  
  <footer id="page-footer">
    <section class="footer-section">
      <div class="container footer-inner">
        <div class="row">
            <div class="col-md-6">
            <a title="go to Waterford Institute of Technology homepage" class="logo site-brand__logo" href="http://wit.ie/">
              <img src="<?php echo $OUTPUT->pix_url('brand-logo', 'theme'); ?>" alt="Waterford Institute of Technology" />
            </a>
            <nav>
              <ul class="footer-nav">
                <li><a href="http://elearning.wit.ie/support">Help</a></li>
                <li><a href="http://docs.moodle.org">Moodle.org Docs</a></li>
                <li><a href="http://elearning.wit.ie/about">Contact Us</a></li>
               </ul>
             </nav>
        </div>
        <div class="col-md-6">
            <p class="site-usage-policy">Users of Moodle in Waterford Institute of Technology are reminded that your use of the Virtual Learning Environment may be logged and this information, with other personal data contained within the system, may be used by lecturers and/or facilitators to monitor progress and completion of modules.</p> 
        </div>     
         </div> <!-- end .row -->
       </div> <!-- end .container -->
     </section>
  </footer>

  <?php echo $OUTPUT->standard_end_of_body_html() ?>

  </body>
</html>
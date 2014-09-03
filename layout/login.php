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
$PAGE->requires->jquery_plugin('edgy', 'theme_edgy');

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

<body <?php echo $OUTPUT->body_attributes(); ?>>

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
        </div>

    </div>
    
    <small class="image-attribution">&copy; Image courtesy of Terry Murphy Photography</small> 
    
</div> <!-- end #page -->

<footer id="page-footer">
    
  <div id="course-footer"><?php echo $OUTPUT->course_footer(); ?></div>
  
  <div class="container footer-inner">
      <a title="go to Waterford Institute of Technology homepage" class="logo site-brand__logo" href="http://wit.ie/">
        <img src="<?php echo $OUTPUT->pix_url('brand-logo', 'theme'); ?>" alt="Waterford Institute of Technology" />
      </a>
    
    <nav>
      <ul class="footer-nav">
        <li><a href="http://elearning.wit.ie/support">Help</a></li>
        <li><a href="http://docs.moodle.org">Moodle.org Docs</a></li>
        <li><a href="/">Privacy Policy</a></li>
        <li><a href="/">Terms of Use</a></li>
        <li><a href="http://elearning.wit.ie/about">Contact Us</a></li>
      </ul>
    </nav>
    
  </div>
  
</footer>

<?php echo $OUTPUT->standard_end_of_body_html() ?>

</body>
</html>

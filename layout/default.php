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


$hassidepre = $PAGE->blocks->region_has_content('side-pre', $OUTPUT);
$hassidepost = $PAGE->blocks->region_has_content('side-post', $OUTPUT);
$hassidefooterleft = $PAGE->blocks->region_has_content('footer-left', $OUTPUT);
$hassidefootermid = $PAGE->blocks->region_has_content('footer-mid', $OUTPUT);
$hassidefooterright = $PAGE->blocks->region_has_content('footer-right', $OUTPUT);

$knownregionpre = $PAGE->blocks->is_known_region('side-pre');
$knownregionpost = $PAGE->blocks->is_known_region('side-post');
$knownregionfooterleft = $PAGE->blocks->is_known_region('footer-left');
$knownregionfootermid = $PAGE->blocks->is_known_region('footer-mid');
$knownregionfooterright = $PAGE->blocks->is_known_region('footer-right');

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

<nav role="navigation" class="<?php echo $settingshtml->navbarclass; ?> navbar-fixed-top">
    <div class="<?php echo $settingshtml->containerclass; ?>">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#moodle-navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?php echo $CFG->wwwroot;?>"><?php echo $SITE->shortname; ?></a>
    </div>

    <div id="moodle-navbar" class="navbar-collapse collapse">
        <?php echo $OUTPUT->custom_menu(); ?>
        <?php echo $OUTPUT->user_menu(); ?>
        <ul class="nav pull-right">
            <li><?php echo $OUTPUT->page_heading_menu(); ?></li>
        </ul>
    </div>
    </div>
</nav>

<div class="<?php echo $settingshtml->containerclass; ?>">
  <header id="page-header" class="clearfix">
      <div id="page-navbar" class="clearfix">
          <nav class="breadcrumb-nav" role="navigation" aria-label="breadcrumb"><?php echo $OUTPUT->navbar(); ?></nav>
          <div class="breadcrumb-button"><?php echo $OUTPUT->page_heading_button(); ?></div>
      </div>
  </header>

  <header class="moodleheader clearfix">
    <div class="courseimage">
      <?php echo $OUTPUT->course_header(); ?>
    </div>
    <?php echo $OUTPUT->page_heading(); ?>
  </header>
</div>

<div id="page" class="<?php echo $settingshtml->containerclass; ?>">
      

    <div id="page-content" class="row">
        <div id="region-main" class="<?php echo $regions['content']; ?>">
            <?php
            echo $OUTPUT->course_content_header();
            echo $OUTPUT->main_content();
            echo $OUTPUT->course_content_footer();
            ?>
        </div>

        <?php
        if ($knownregionpre) {
            echo $OUTPUT->blocks('side-pre', $regions['pre']);
        }?>
    </div>

</div> <!-- end #page -->

<?php if($hassidefooterleft || $hassidefootermid || $hassidefooterright) { ?>
<aside id="pre-footer" class="pre-footer"> 
  <div class="container">
    <section class="col-md-4 footer-region footer-region--left">
    <?php
      if ($knownregionfooterleft) {
          echo $OUTPUT->blocks('footer-left');
      }?>
    </section> <!-- end .footer-region--left -->

    <section class="col-md-4 footer-region footer-region--mid">
      <?php
        if ($knownregionfootermid) {
            echo $OUTPUT->blocks('footer-mid');
        }?>
    </section> <!-- end .footer-region--mid --> 

    <section class="col-md-4 footer-region footer-region--right">
      <?php
        if ($knownregionfooterright) {
            echo $OUTPUT->blocks('footer-right');
        }?>
    </section> <!-- end .footer-region--right -->
  </div>
</aside> <!-- end .pre-footer -->
<?php } ?>

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
        <li><a href="http://elearning.wit.ie/about">Contact Us</a></li>
      </ul>
    </nav>
    
  </div>
  
</footer>

<?php echo $OUTPUT->standard_end_of_body_html() ?>

</body>
</html>

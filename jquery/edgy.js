var edgy = edgy || {};

/** 
 * basic querystring function for extracting query params
 */
edgy.qs = function(key) {
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars[key];
}

$(function(){ 
  
  $(".content--editing")
    .before(function(){
      return "<a href=\"#\" class=\"content-toggle\" title=\"Click to expand or collapse\" data-text-swap=\"Hide\">Show</a>";
    });
  
  // event listener to handle text toggle on show/hide link   
  $(".content--editing").on("show.bs.collapse hide.bs.collapse", function() {
    var $link = $(this).prev(".content-toggle");
    if ($link.text() == $link.data("text-swap")) {
      $link.text($link.data("text-original"));
    } else {
      $link.data("text-original", $link.text());
      $link.text($link.data("text-swap"));
    }
  });
  
  // event listener on content-toggle link to handle show/hide on content
  $(".section .content-toggle")  
    .click(function(event){
      event.preventDefault();
      var dis = $(this);
      dis
        .parent()
        .find(".content--editing")
        .collapse('toggle');
      });
      
   var section = $(location).attr('hash');
   
   // attempt to extract section from querystring
   if (!section || 0 === section.length) {
     if (edgy.qs('section')) {
        section = '#section-' + edgy.qs('section');
     }
   }
   
   // reveal topic content and scroll to topic if there is a section present
   if (section) {
     $(section + " .content--editing")
       .collapse('show');
       
     var scrollpos = $(section).offset().top - $('nav[role="navigation"]').filter(':first').height(); 
     
     $('body')   
       .animate({
           scrollTop: scrollpos
           }, 500);
   }    

   // identify .inplace-help instances and convert them to popovers 
   $('.inplace-help').each(function() {
      var $this = $(this); // current inplace element
      var popover = '<span><button type="button" class="js-help-popover btn btn-default btn-sm" data-toggle="popover" data-container="body">Tell me more &#187;</button></span>';
      var activity = $this.parents('.activity').find('.activityinstance');
      
      activity.append(popover);
      
      $popover = $('.js-help-popover').popover({
        html: true,
        placement: 'auto',
        content: function () {
          return $this.html();
        }
      });
      
      $popover.on('show.bs.popover', function(){
        $('.js-help-popover').not(this).popover('hide');  
      });
      
      $('body').on('click', function (e) {
          //only buttons
          if ($(e.target).data('toggle') !== 'popover'
              && $(e.target).parents('.popover.in').length === 0) { 
              $('[data-toggle="popover"]').popover('hide');
          }
      });
      
   });
});
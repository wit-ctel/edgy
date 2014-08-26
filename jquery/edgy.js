
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
   
   // reveal topic content and scroll to topic if it appears in url
   if (section) {
     $(section + " .content--editing")
       .collapse('show');
      
     $(section)   
       .animate({
               scrollTop: $(section).offset().top
           }, 1000);
   }    

   // identify .inplace-help instances and convert them to popovers 
   $('.inplace-help').each(function() {
      var $this = $(this); // current inplace element
      var popover = '<span><button type="button" class="help-popover" data-toggle="popover" data-container="body">Tell me more</button></span>';
      var activity = $this.parents('.activity').find('.activityinstance');
      
      activity.append(popover);
      
      $popover = $('.help-popover').popover({
        html: true,
        placement: 'auto',
        content: function () {
          return $this.html();
        }
      });
      
      $popover.on('show.bs.popover', function(){
        $('.help-popover').not(this).popover('hide');  
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
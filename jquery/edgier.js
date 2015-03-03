$(function(){ 
  
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
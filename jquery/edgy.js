
$(function(){ 
  
  $(".content--editing")
    .before(function(){
      return "<a href=\"#\" class=\"content-toggle\" title=\"Click to expand or collapse\" data-text-swap=\"Hide topic\">Show topic</a>";
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
   
   if (section) {
     $(section + " .content--editing")
       .collapse('show');
      
     $(section)   
       .animate({
               scrollTop: $(section).offset().top
           }, 1000);
   }    
});

$(function(){ 
  
  $(".content--editing")
    .before(function(){
      return "<a href=\"#\" class=\"content-toggle\" title=\"Click to expand or collapse\" data-text-swap=\"Hide topic\">Show topic</a>";
    });
    
  $(".section .content-toggle")  
    .click(function(event){
      event.preventDefault();
      var dis = $(this);
      if (dis.text() == dis.data("text-swap")) {
        dis.text(dis.data("text-original"));
      } else {
        dis.data("text-original", dis.text());
        dis.text(dis.data("text-swap"));
      }
      dis
        .parent()
        .find(".content--editing")
        .collapse('toggle');
      });
});
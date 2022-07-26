$(document).ready( function () {
    $('#add_btn').on("click", function(e){
      e.preventDefault();
      const postData= {
        name:$('#add_name').val(),
        description:$('#add_description').val(),
        categoria:$('#add_categoria').val()
      };

      $.post('/add_back',postData,function(data){
         console.log(data);
         $('#add_form').trigger('reset');
         $.getScript('js/list/read.js', function(){});
      });
      
    });
 
  });
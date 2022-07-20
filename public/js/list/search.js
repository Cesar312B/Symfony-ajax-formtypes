$(document).ready( function () {
   $(document).on('click','#navBtn', function(){
  location.reload();
   });

    $('#search').keyup( function(){
    $('#collapseExample').removeClass("show");
    let search = $('#search').val();

    $.ajax({
        url: '/search_back',
        data: {search},
        type: 'POST',
        success: function(data){
           let content = '';
           $(document).on('click','li', function(){
             let= valor = $(this).attr('name');
             $('#search').val(valor);
             $('#collapseExample').removeClass("show");

             $(document).on('click','body', function(){
                $('#collapseExample').removeClass("show");
             });
           });
           data.forEach(task => {
             content+=` 
                <li name="${task.name}">
                <a class="search_item text_decoration-none text-reset">
                ${task.name}
                </a>
                </li>
                ` 
           });

           if (data == '') {
            $('#collapseExample').removeClass("show");
           } else {
            $('#search_container').html(content);
            $('#collapseExample').addClass("show");
           }
        } 
   }); 

   $(document).on('click','#btnSearch', function(){

      let busca=  $('#search').val();
      $('#content').load('/read_task', {'var1':busca});
   });

   $(document).on('click','#search', function(){
       $('#search').val('')
   });


});

});
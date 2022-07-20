$(document).ready( function () {

    $(document).on('click','.taskEditBtn', function(e){

        $('#add_form_view').addClass('d-none');
        $('#edit_form-view').removeClass('d-none');
        $('#btnBackAdd').removeClass('d-none');

        $('#btnBackAdd').click(function(){
            $('#edit_form-view').addClass('d-none');
            $('#add_form_view').removeClass('d-none');
            $('#btnBackAdd').addClass('d-none');

        });

        let element = $(this)[0].parentElement.parentElement;
        let info= $(element).attr('attr_info');
        array_info = info.split(',');
        $('#edit_name').val(array_info[1]);
        $('#edit_description').val(array_info[2]);

        $(document).on('click','#btnEditForm', function(e){
            e.preventDefault();

            const postData= {
                name:$('#edit_name').val(),
                description:$('#edit_description').val(),
                id: array_info[0]
              };

            $.ajax({
                 url: '/edit_back',
                 data: {postData},
                 type: 'POST',
                 success: function(data){
                    console.log(data);
                    $('#adit_form').trigger('reset');
                    $.getScript('js/list/read.js', function(){});
                 } 
            });  

        });   



    });
});
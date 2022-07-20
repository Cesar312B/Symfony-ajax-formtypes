$(document).ready( function () {
    $(document).on('click','.task-delete', function(e){

        let element = $(this)[0].parentElement.parentElement;
        let info= $(element).attr('attr_info');
        array_info = info.split(',');

        if(confirm('Esta seguro de eliminar el task'+'"'+array_info[1]+'"')){
            $.post('/delete_back',{id:array_info[0]},function(data){
                console.log(data);
                $.getScript('js/list/read.js', function(){});
             });
        }


    });
});
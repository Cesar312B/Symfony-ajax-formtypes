$(document).ready( function () {
    getAllTasks();
} );

function getAllTasks(){
   $.ajax({
       url: '/read_back',
       type: 'POST',
       success: function (data){
         let content= '';
         let count= 0;
         data.forEach(task => {
           count++;
           content +=`    
             <tr attr_info="${task.id},${task.name},${task.description}">
               <td>${count}</td>
               <td data="${task.name}">
               <a href="#">${task.name}</a>
               </td>
               <td>${task.description.slice(0, 35)}...</td>
               <td>
               <button class="task-delete btn btn-danger btn-sm">Delelte</button>
               <button class="taskEditBtn btn btn-warning btn-sm ">Edit</button>
               </td>
               </tr> 
               ` ;
         });
         $("#total_num_tasks").html(count);
         $("#tasks").html(content);
       }
   });
}
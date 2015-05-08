$(document).ready(function(){
      
    $("select[name='Actividad\\[id_disciplina\\]']").change(function(){

        if ($(this).val() == 3) { // 3 es Fitness

             $('#instructor').show();

        }else{

            $('#instructor').hide();
        }
        
        
    });
});
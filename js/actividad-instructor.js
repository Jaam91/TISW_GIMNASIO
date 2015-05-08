$(document).ready(function(){
        
        $('#instructor').hide();
    
    $("select[name='Actividad\\[id_disciplina\\]']").change(function(){

        if ($(this).val()== 3) { 

             $('#instructor').show();

        }else{

            $('#instructor').hide();
        }
        
        
    });
});
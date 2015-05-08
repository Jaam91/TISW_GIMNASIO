$(document).ready(function(){
        
        $('#tipo').hide();
        $('#horario').hide();
    
    $("select[name='Usuario\\[rol\\]']").change(function(){

        if ($(this).val()== 'Instructor') { 

             $('#tipo').show();
             $('#horario').show();

        }else{

            $('#tipo').hide();
            $('#horario').hide();
        }       
        
    });
});
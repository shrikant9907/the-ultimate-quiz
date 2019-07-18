/*
 * Save Quiz Result By Ajax 
 */

function tuq_save_quiz_result(){

   var quizform = jQuery('#tuq_quiz_form').serialize();
    
    jQuery.ajax({ 
        type: 'POST',   
        url: AJAXOBJ.ajaxurl, 
        data: { 
            "action": "tuq_save_quiz_result_action",
            'formdata': quizform
        }, 
        success: function(data){ 
            jQuery('.tuq_result_popup').remove();
            jQuery('body').append('<div class="tuq_result_popup"><div class="tuq_popup"><h3>Result</h3><span class="close">X</span>'+data+'</div></div>');
            jQuery('.tuq_result_popup .close').click(function(){
                jQuery(this).parent().parent().remove();  
            });

        }	 
        
    });
    
}
 

 


// jQuery for add new field 
jQuery(document).ready(function() {

 
    var MaxNumberOfQuestions    = 20;  // Max Number of Questions
 
    var AddQuestionsButton = jQuery(".add_new_question_wr a"); // Add Options Button
    var OptionsContainer = jQuery('.tuq_options_container'); // Options Container
    var QuestionsContainer = jQuery('.tuq_add_quiz_question_box').parent(); // Options Container
    var NumberOfQuestions = jQuery('.number_of_questions');
 
    var InitQuestion = parseInt(NumberOfQuestions.val());  // Initial Questions
   
        // Add Options Button Click 
    function add_new_options() {
    var AddOptionsButton        = jQuery(".add_ans_options a"); // Add Options Button
    var MaxNumberOfOptions      = 5; // Max Number of Options
    var InitOption = 1; // Initial Options
    jQuery(AddOptionsButton).click(function(e){ 
        e.preventDefault();

        if(InitOption < MaxNumberOfOptions){ 
            InitOption++;
            var nameattr = jQuery(this).parent().prev().children('input').attr('name'); 
            var checkboxnameattr = jQuery(this).parent().parent().next().children('input').attr('name'); 
            jQuery(this).parent().before('<div class="tuq_new_options_box tuq_options_no'+InitOption+'"><span>Option '+InitOption+':</span><input type="text" placeholder="Enter Option Here." class="tuq_quiz_option" value="" name="'+nameattr+'"><span class="remove_option">Remove Option</span></div>');
            jQuery(this).parent().parent().next().append('<input type="checkbox" value="'+(InitOption-1)+'" name="'+checkboxnameattr+'" />Option'+InitOption+'<br>'); 
           
        } else {
            jQuery('.tuq_warning_alert').remove();
            jQuery(this).parent().before('<div class="tuq_warning_alert">You can add maximum 5 options only.</div>');
        }
    });
   
    jQuery(OptionsContainer).on("click",".remove_option", function(e){ 
        e.preventDefault(); 
            jQuery(this).parent('.tuq_new_options_box').remove(); 
            InitOption--;
    });
    }
    add_new_options(); 

    // Add Question Button Click 
    jQuery(AddQuestionsButton).click(function(e){ 
        e.preventDefault();

        if(InitQuestion <= MaxNumberOfQuestions){ 
            InitQuestion++;
            jQuery(this).parent().before('<div class="tuq_add_quiz_question_box tuq_add_quiz_question_box'+InitQuestion+'"><div class="tuq_add_quiz_question tuq_question_no'+InitQuestion+'"><span>Question '+InitQuestion+':</span><input type="text" placeholder="Enter Question Here." class="tuq_quiz_question" value="" name="tuq_quiz_question'+InitQuestion+'"></div><div class="tuq_options_container"><div class="tuq_new_options_box tuq_options_no1"><span>Option 1:</span><input type="text" placeholder="Enter Option Here." class="tuq_quiz_option" value="" name="tuq_quiz_option'+InitQuestion+'[]"> </div><div class="add_ans_options"><a href="javascript:void(0);">Add New Options</a></div></div><div class="select_correct_answer"><label for="tuq_quiz_answer'+InitQuestion+'[]">Select Correct Answers:</label><br /><input type="checkbox" value="0" name="tuq_quiz_answer'+InitQuestion+'[]" />Option1 <br></div><span class="remove_question">Remove Question</span></div>');
            jQuery('.number_of_questions').val(InitQuestion);

        } else {
            jQuery('.tuq_warning_alert').remove();
            jQuery(this).parent().before('<div class="tuq_warning_alert">You can add maximum 20 Questions only.</div>');
        }

        add_new_options(); 
    });
   
    jQuery(QuestionsContainer).on("click",".remove_question", function(e){ 
        e.preventDefault(); 
            jQuery(this).parent('.tuq_add_quiz_question_box').remove(); 
            InitQuestion--;
            jQuery('.number_of_questions').val(InitQuestion);
    });

});


// Ajax code 

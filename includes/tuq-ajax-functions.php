<?php 
//Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
* Function for load more posts on ajax call
*/
function tuq_save_quiz_result_action() {

    parse_str($_POST['formdata'],$formdata);
    // print_r($formdata); 
   	$ans_count = 0;

    foreach($formdata as $f_key => $data) {

    	if($ans_count>0) { 
			$quiz_posts = get_post_meta(13,'_tuq_quiz_question'.$ans_count,true);
			$answers = $quiz_posts['answer'];
			
			echo "Answer $ans_count: ";

			if(is_array($formdata['quiz_question'.$ans_count])) {
			if($formdata['quiz_question'.$ans_count]==$answers) {
				echo "Correct! <br />"; 
			} else {
				echo "Incorrect! <br />"; 
			}
		} else {
			foreach($answers as $answer_val) {
				if(!is_array($formdata['quiz_question'.$ans_count])) {

					if($answer_val==$formdata['quiz_question'.$ans_count]) {
						echo "Correct! <br />";
					} else {
						echo "Incorrect! <br />";
					}
				}
				
			}
		}
		} 

    	$ans_count++; 


    }

	wp_die(); 
}

add_action('wp_ajax_tuq_save_quiz_result_action', 'tuq_save_quiz_result_action');
add_action( 'wp_ajax_nopriv_tuq_save_quiz_result_action', 'tuq_save_quiz_result_action' );
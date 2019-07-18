<?php
//Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/*
* Shortcode for show Quiz 
*/
function tuq_show_shortcode() {

	ob_start(); 

		?>
			<div class="tuq_quiz_container">

			<form id="tuq_quiz_form" action="" method="post" enctype="multipart/form-data">

			<?php 
			$args = array('post_type'=>'the_ultimate_quiz',
				'posts_per_page' => 1
				);
			query_posts($args);
			while(have_posts()): the_post(); 
			$post_id = get_the_ID();
			$postmeta = get_post_meta($post_id);
	
			$noq = $postmeta['_tuq_number_of_questions']['0'];
		  	
		  	$q = 1;

		  	while($q<=$noq) {
		  		$questions = get_post_meta($post_id,'_tuq_quiz_question'.$q, true);
	 
					$question = $questions['question'];
					$options = $questions['options'];
					$answer = $questions['answer'];

					$anssize = sizeof($answer);
			if(!empty($question) && !empty($options)) {

			?>

			<div class="tuq_quiz_question_wr <?php if($q==1) { echo 'active'; } ?>">
				 
				<input type="hidden" name="post_type" value="<?php echo $post_id; ?>" />
	
				<div class="tuq_question"><span>Question <?php echo $q; ?>. </span><?php echo $question; ?></div>
				<div class="tuq_question_answer"><?php if($anssize==1) { echo'Select a answer.'; } else { echo "You can select more than 1 options for this question."; } ?></div>
				<div class="tuq_answere">
					<ul>
						
						<?php 
						foreach($options as $opkey => $option) { 
						
							if($anssize==1) { 
								 
						?>

						
						<li><input type="radio" name="quiz_question<?php echo $q; ?>" id="quiz_option<?php echo $q.$opkey; ?>" value="<?php echo $opkey; ?>" /><label for="quiz_option<?php echo $q.$opkey; ?>"><span><?php echo $opkey+1; ?>) </span><?php echo $option; ?></label></li>
						<?php } else {
							?>
						
						<li><input type="checkbox" name="quiz_question<?php echo $q; ?>[]" id="quiz_option<?php echo $q.$opkey; ?>" value="<?php echo $opkey; ?>" /><label for="quiz_option<?php echo $q.$opkey; ?>"><span><?php echo $opkey+1; ?>) </span><?php echo $option; ?></label></li>
							<?php
							} 
						} ?>
					</ul>
				</div>
				
			</div>
			<!-- tuq_quiz_question_wr end -->
 			<?php 
 				}
			  		$q++;
			  	}
		  
 			endwhile; wp_reset_query(); ?>
			</form>

			</div>

			<div class="tuq_next_prev_nav">
				
				 <a href="javascript:void(0);" class="tuq_prev_btn disabled">&larr; Prev Question</a>
				 <a href="javascript:void(0);" class="tuq_next_btn disabled">Next Question &rarr;</a>

			</div>

			<div class="submit_quiz_ans"><a onclick="tuq_save_quiz_result();" href="#<?php //echo site_url('/quiz-result?result'); ?>">Submit</a></div>

		<?php

	$show_quiz = ob_get_clean();

	return $show_quiz; 

}

add_shortcode('show_quiz','tuq_show_shortcode');

/*
* Show quiz result
*/
function tuq_show_quiz_result() {

	$show_quiz_result = '';

	return $show_quiz_result;

}
add_shortcode('show_quiz_result','tuq_show_quiz_result');
//[show_quiz_result]
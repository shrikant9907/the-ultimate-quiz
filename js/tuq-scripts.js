
var QuizContainer = jQuery('.tuq_quiz_container');
var Question = jQuery('.tuq_quiz_question_wr');
var ActiveQuestion = jQuery('.tuq_quiz_question_wr.active');
var NumberOfQuestions = jQuery('.tuq_quiz_question_wr').length;
var NextQuestionButton = jQuery('.tuq_next_btn');
var PrevQuestionButton = jQuery('.tuq_prev_btn');
var NextPrevQuestion = jQuery('.tuq_next_prev_nav');


NextPrevQuestion.attr('data-question',1); // For first quiz
NextQuestionButton.addClass('disabled');
PrevQuestionButton.addClass('disabled');

function radio_select() {
// Radio Select  
AnswerOption = jQuery('.tuq_quiz_question_wr.active .tuq_answere ul li');  
AnswerOption.click(function(e){

	if(AnswerOption.children('input').is(':radio')) {
		AnswerOption.removeClass('tuq_checked_ans');
		jQuery(this).addClass('tuq_checked_ans');
	} else {
		e.preventDefault();	
		jQuery(this).toggleClass('tuq_checked_ans');
			if (jQuery(this).children('input').is(':checked'))
				jQuery(this).children('input').prop('checked', false);
			else
				jQuery(this).children('input').prop('checked', true);
			
	}

	AnswerOption.parent().children().each(function(){ 
		var CheckSelectedOption = jQuery(this).hasClass('tuq_checked_ans'); 
		if(CheckSelectedOption){
			NextQuestionButton.removeClass('disabled');
		} 
	});	

	var current = NextPrevQuestion.attr('data-question');		
	if(current>=NumberOfQuestions) {
		NextQuestionButton.addClass('disabled');
		jQuery('.submit_quiz_ans').show();
	}

});
}

radio_select();// Init Call

// Next Question Code 
NextQuestionButton.click(function(e){
		e.preventDefault();

	var current = NextPrevQuestion.attr('data-question');
		current++; 
		NextPrevQuestion.attr('data-question',current);

		ActiveQuestion.removeClass('active');
		ActiveQuestion.next().addClass('active');
		ActiveQuestion = jQuery('.tuq_quiz_question_wr.active');

		PrevQuestionButton.removeClass('disabled');
		NextQuestionButton.addClass('disabled');

		ActiveQuestion.children('.tuq_answere').children('ul').children('li').each(function(){ 
			var CheckSelectedOption = jQuery(this).hasClass('tuq_checked_ans'); 
			if(CheckSelectedOption){
				NextQuestionButton.removeClass('disabled');
				jQuery('.submit_quiz_ans').show();
			} 
		});	

		var current = NextPrevQuestion.attr('data-question');		
		if(current>=NumberOfQuestions) {
			NextQuestionButton.addClass('disabled');
		} else {
			jQuery('.submit_quiz_ans').hide();
		
		}

		radio_select();// Second call
		
});

// Prev Question Code 
PrevQuestionButton.click(function(e){ 
		e.preventDefault();
	var current = NextPrevQuestion.attr('data-question');
		
		current--;
		NextPrevQuestion.attr('data-question',current); 

		if(current<=1) {
			jQuery(this).addClass('disabled');
		}

		ActiveQuestion.removeClass('active');
		ActiveQuestion.prev().addClass('active');
		ActiveQuestion = jQuery('.tuq_quiz_question_wr.active');

		NextQuestionButton.removeClass('disabled');
		
		radio_select();//Third Call\
		jQuery('.submit_quiz_ans').hide();
		
});


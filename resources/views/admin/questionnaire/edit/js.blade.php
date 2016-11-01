<script type="text/javascript">
(function(undefined) {
	var updateQuestions = function (deletedQuestion) {
		var prevQuestionsLength = deletedQuestion.prevAll('.question').length;
		deletedQuestion.nextAll('.question').each(function (index) {
			$(this).find('.form-control').each(function () {
				var elt = $(this);
				var pieces = elt.attr('name').split("_");
				var sub = elt.closest('.choice').length ? 1 : 2;
				pieces[pieces.length - sub] = prevQuestionsLength + index + 1;
				elt.attr('name', pieces.join("_"));
			});
			$(this).find('.question-title').each(function () {
				$(this).html("Question " + (prevQuestionsLength + index + 1));
			});
		});
		return deletedQuestion;
	};
	
	var updateChoices = function (deletedChoice) {
		var prevChoicesLength = deletedChoice.prevAll('.choice').length;
		deletedChoice.nextAll('.choice').each(function (index) {
			$(this).find('input').each(function () {
				var input = $(this);
				var pieces = input.attr('name').split("_");
				pieces[pieces.length - 1] = prevChoicesLength + index + 1;
				input.attr('name', pieces.join("_"));
			});
		});
		return deletedChoice;
	};
	
    $(function() {
        $('#add-new-question-btn').click(function() {
            var question_number = $('#questions-form').children().length + 1;
            var questionForm = $('#template-question').children().clone();
            questionForm.find('.question-title').html("Question " + question_number);
            //questionForm.find('input[type="hidden"]').val(question_number);
            questionForm.find('.form-control').each(function() {
                var t = $(this);
                t.attr('name', t.attr('name') + question_number);
            });
            $('#questions-form').append(questionForm);
            return false;
        });
        
        $('#questions-form').on('click', '.add-new-choice-btn', function() {
            var t = $(this);
            var question = t.closest('.question');
            var choices = question.find('.choices');
            var choices_nb = choices.children().length + 1;
            var question_nb = question.prevAll('.question').length + 1;
            var choiceForm = $('#template-choice').children().clone();
            choiceForm.find('input').each(function () {
                $(this).attr('name', $(this).attr('name') + question_nb + '_' + choices_nb);
            });
            choices.append(choiceForm);
            return false;
        });
        
        $('#questions-form').on('click', '.destroy-question-btn', function() {
            updateQuestions($(this).closest('.question')).remove();
            return false;
        });
        
        $('#questions-form').on('click', '.destroy-choice-btn', function() {
        	updateChoices($(this).closest('.choice')).remove();
            return false;
        });
        
        $('#questionnaire-form').submit(function() {
            var formOk = true;
            var form = $(this);
            form.find('.alert-danger:not(.hide)').addClass('hide');
            if (form.find('input[name="name"]').val() === "") {
                $('#alert-questionnaire-name-empty').removeClass('hide');
                formOk = false;
            }
            var questions = $('#questions-form').children();
            if (questions.length === 0) {
                $('#alert-no-question').removeClass('hide');
                formOk = false;
            } else {
                questions.each(function() {
                    var question = $(this);
                    if (question.find('input[name^="question-name-"]').val() === "") {
                        question.find('.alert-question-name-empty').removeClass('hide');
                        formOk = false;
                    }
                    var choices = question.find('.choices').children();
                    if (choices.length === 0) {
                        question.find('.alert-no-choice').removeClass('hide');
                        formOk = false;
                    } else {
                        choices.find('input[type="text"]').each(function() {
                        	var input = $(this);
                            if (input.val() === "") {
                                input.nextAll('.alert-choice-name-empty').removeClass('hide');
                                formOk = false;
                            }
                        });
                    }
                });
            }
            return formOk;
        });
    });
})();
</script>
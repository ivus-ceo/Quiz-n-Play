function __summonOneRow(e) {
  event.preventDefault();
  $('.content-wrapper form').css({
    'width': '400px'
  });
  $('.question-container').css({
    'justify-content': 'space-between'
  });
  $('.question').css({
    'width': '100%',
    'margin-left': '0'
  });
}

function __summonTwoRow(e) {
  event.preventDefault();
  $('.content-wrapper form').css({
    'width': '100%'
  });
  $('.question-container').css({
    'justify-content': 'space-between'
  });
  $('.question').css({
    'width': 'calc(50% - .2rem)',
    'margin-left': '0'
  });
}

function __summonThreeRow(e) {
  event.preventDefault();
  $('.content-wrapper form').css({
    'width': '100%'
  });
  $('.question-container').css({
    'justify-content': 'flex-start'
  });
  $('.question').css({
    'width': 'calc(33% - .2rem)',
    'margin-left': '.4rem'
  });
  $('.question:nth-child(3n + 1)').css('margin-left', '0');
}

function __addQuestion(e) {
  var a = $('.question-container .question:nth-of-type(1)').html();
  var b = $('.question-container .question:nth-of-type(2)').attr('style');
  $('.question-container .question:nth-last-of-type(1)').after('<div class="question" style="' + b + '">' + a + '</div>');
}

function __removeQuestion(e) {
  $(e).parentsUntil('.question-container').remove();
}

function __addAnswer(e) {
  var a = $('.question-container .question .question-answer:nth-last-child(2)').html();
  $('.question-container .question .add-question-answer').before('<div class="question-answer">' + a + '</div>');
}

function __removeAnswer(e) {
  var a = $('.question-answer:nth-last-child(2)').remove();
}

function __rightAnswer(e) {
  alert('В эту строку заносится правильный ответ!');
}

function __setTimer() {
  var d = new Date();
  var testTime = $('.quiz-questions-container').attr('timer');
  var dateFuture = Date.now() + parseInt(testTime);
  var x = setInterval(function() {
    var dateNow = Date.now();
    var diff = dateFuture - dateNow;
    var seconds = Math.floor((diff % (1000 * 60)) / 1000);
    var minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
    $('#timer').html('Осталось: ' + minutes + ':' + seconds);
    if (diff <= 0) {
      $('#testForm').submit();
    }
  }, 1000);
}

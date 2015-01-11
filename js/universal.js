jQuery.fn.putCursorAtEnd = function() {
  return this.each(function() {
    $(this).focus()
    if (this.setSelectionRange) {
      var len = $(this).val().length * 2;
      this.setSelectionRange(len, len);
    } else {
      $(this).val($(this).val());      
    }
    this.scrollTop = 999999;
  });
};

var LEFT = 37;
var RIGHT = 39;
var DELETE = 46;
var BACKSPACE = 8;
var ZERO = 48;
var NINE = 57;

$(document).ready(function() {
  if(error_message_return)
    $(".error_message").slideDown(450).delay(10000).slideUp(450);
  else
    $(".error_message").slideDown(450).delay(10000);
  
  $(".success_message").slideDown(450).delay(500).fadeOut(450);

  $(".focus_field").putCursorAtEnd();

  $("img").on('dragstart', function(event) { event.preventDefault(); });

  $(".phone_number").keypress(function(event) {
    // 0 = 48
    // 9 = 57
    var code = event.which;
    event.preventDefault();

    var nums = $(this).val();
    var start = nums.substr(0, $(this).getCursorPosition());
    var end = nums.substr($(this).getCursorPosition());
    nums = start + (code - ZERO) + end;

    //var nums = $(this).val() + (code - ZERO);
    nums = nums.replace("(", "");
    nums = nums.replace(")", "");
    nums = nums.replace("-", "");
    nums = nums.replace(" ", "");

    var start = nums.substring(0, 3);
    var middle = nums.substring(3, 6);
    var end = nums.substring(6, 10);

    if (nums.length > 5) {
      nums = "(" + start + ") " + middle + "-" + end;
    } else if(nums.length > 2) {
      nums = "(" + start + ") " + middle;
    } else if(nums.length > 0) {
      nums = "(" + start;
    }

    $(this).val(nums);
  });
});
      //(012) 345-6789
      //012 345 6789
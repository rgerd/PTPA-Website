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

$(document).ready(function() {
  $(".error_message").slideDown(450).delay(10000).slideUp(450);
  
  $(".success_message").slideDown(450).delay(500).fadeOut(450);

  $(".focus_field").putCursorAtEnd();
});
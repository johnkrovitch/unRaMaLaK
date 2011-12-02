$(document).ready(function(){
  // homepage
  $('.login .login-link').click(function(e){

    if($(this).isClicked()){
      $('.login .hidden').slideDown('fast');
      $(this).find('span').text(htmlDecode('&and;'));
      $(this).removeClass('clicked');

    }else{
      $('.login .hidden').slideUp('fast');
      $(this).find('span').text('>');
      $(this).addClass('clicked');
    }
    e.preventDefault();
  });
});
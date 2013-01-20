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

  // menu bar login
  if($('#menu-bar .login').length != 0){
    $('#menu-bar .login').addHiddenMenu('.login-hidden');
  }
  /*$('form.login-form input[type="submit"]').click(function(e){
    var form = $(this).parents('form');
    var submit = $(this);

    submit.hide();
    form.find('.loader').show();
    $.ajax({
      type: 'post',
      url: form.attr('action'),
      data: form.serialize(),
      success: function(data){
        form.find('.loader').hide();
        submit.show();
      }
    });

    e.preventDefault();
  });*/

  if(typeof sfWebDebugToggleMenu == 'function'){
    //sfWebDebugToggleMenu();
  }
});
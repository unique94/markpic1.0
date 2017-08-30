jQuery(function($) {'use strict',
  $('#login-btn').click(function(event){
    event.preventDefault();
    var username = $('#username').val();
    var password = $('#password').val();
    if(!/^[0-9a-zA-Z]+$/.test(username) || !/^[0-9a-zA-Z]+$/.test(password)){
      $('#message-tip').html('<div class="alert alert-danger"><strong>只允许输入字母，数字!</strong></div>');
    }else{
      $.ajax({
        url: 'check_login.php',
        type: 'POST',
        data:{
          'username': username,
          'password': password,
          'action': 'login',
          't': Math.random()
        },
        dataType:'json',
        success: function(data){
          $('#login-btn').html('登录');
          if(data.status == 0){
            $('#message-tip').html('<div class="alert alert-success"><strong>' + data.msg + '</strong></div>');
            location.href = 'user.php';
          }else{
            $('#message-tip').html('<div class="alert alert-danger"><strong>' + data.msg + '</strong></div>');
          }
        },
        beforeSend: function(){
          $('#login-btn').html('<i class="fa fa-spinner fa-pulse"></i> 正在登录..');
        },
        error: function(){
        }

      });
    }
    return false;

  });
});

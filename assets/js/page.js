jQuery(function($) {'use strict',

/*获取url的参数*/
$.getUrlPara = function(name){
    var url_list = location.search;
    if(url_list == ""){
        return "";
    }else{
        var reg = new RegExp(name+"=([^&]+)");
        var res = url_list.match(reg);
        if(res){
            return res[1];
        }else{
            return "";
        }
    }
};

var one_page_num = 30;
var cur_page = $.getUrlPara('page');
if(cur_page == "") cur_page = 1;
else cur_page = parseInt(cur_page);

var cur_url = 'index.php?page=';
var from_url = 'index';
var pre_from = 'mask', pre_status = 1;
if(location.href.indexOf('filter.php') != -1){
  cur_url = 'filter.php?page=';
  from_url = 'filter';
  pre_from = 'filter';
  pre_status = 2;
  $('.tiles article').css({'width': 405, 'height': 405});
}else if(location.href.indexOf('clean.php') != 1){
  cur_url = 'clean.php?page=';
  from_url = 'clean';
  pre_from = 'clean';
  pre_status = 3;
}
if(cur_page > 1){
  $('#pre_page').attr('href',cur_url + (cur_page - 1));
}else{
  $('#pre_page').removeAttr('href');
}
$('#post_page').attr('href',cur_url + (cur_page + 1));
$('#page').html(cur_page);
/*请求图片*/
$.ajax({
  url: 'load.php',
  data:{
    'num': one_page_num,
    'cur_page': cur_page,
    'action': 'get',
    'from': from_url,
    '_': Math.random()
  },
  dataType: 'json',
  type: 'GET',
  success: function(data){
    if(data.status == 0){
      if(typeof data.img != 'undefined'){
        $.loadPic(data.img, $('.tiles'));
        var total_page = parseInt(data.picNum / one_page_num);
        if(parseInt(data.picNum) % parseInt(one_page_num) != 0) total_page ++;
        $("#total_page").html(total_page);
        if(data.next == 0){
          $('#post_page').removeAttr('href');
        }
      }else{
        //todo
      }
    }
  },
  error: function(){
    alert('error');
  }
});

/*结束任务*/
$('#finish-btn').click(function(){
  if(save_flag == 0){
    alert('请先点击保存!');
  }else{
    var that = $(this);
    $.ajax({
      url: 'update.php',
      type: 'POST',
      dataType: 'json',
      data:{
        'status' : pre_status,
        'action' : 'finish',
        'from': pre_from,
        '_' : Math.random()
      },
      success: function(data){
        if(data.status == 0){
          that.html('处理完成,正在跳转...');
          setTimeout(function(){
            location.href = 'user.php';
          }, 300);
        }else{
            location.href = 'user.php';
        }
      },
      beforeSend: function(){
        that.html('正在处理...');
      },
      error: function(){
      }
    });
  }

});

$(window).bind('beforeunload', function() {
  if($('#return-login').length == 0 && save_flag == 0){
      return '有内容尚未保存!';
  }
});

});

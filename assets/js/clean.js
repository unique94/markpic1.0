
jQuery(function($) {'use strict',

cancel_list = {};

/*load pic*/
$.loadPic = function(data, dom){

  function choose(id) {
    if($('#i'+id).attr('data') == '0'){
      $('#i'+id).css('opacity', 0.4);
      $('#i'+id).attr('data','1');
      $('#l' + id).html('已标记');
      cancel_list[id] = -1;
    }else{
      $('#i'+id).css('opacity', 1.0);
      $('#i'+id).attr('data','0');
      $('#l' + id).html('');
      delete cancel_list[id];
    }
  }


  var scale =1.0, cur_img_div, tmp_img = dom.find('.tmpart') ;
  for(var i = 0; i < data.length; i++){
    cur_img_div = tmp_img.clone();
    cur_img_div.show();
    var src = data[i][1], id = data[i][0], cur_img = cur_img_div.find('img');
    var label = cur_img_div.find('label');

    var button = cur_img_div.find('button');
    
    label.attr("id", 'l' + id);
    button.attr("id", 'b' + id);
    cur_img_div.attr('id', 'a' + id);
    cur_img.attr('src', src).attr('id', 'i' + id).attr('data', '0');
    cur_img.css('width', data[i]['width']).css('height', data[i]['height']);

    cur_img_div.removeClass('tmpart');
    cur_img_div.appendTo(dom);

    /*选中*/
    (function(id){
      $('#i' + id).click(function(){choose(id); });
    })(id);

    /*替换图片*/
    (function(id){
      $('#b' + id).click(function(){
        var jizhun = $('#jzimg');
        var oldsrc = jizhun.attr('src');
        var newsrc = $('#i'+id).attr('src');
        jizhun.attr('src', newsrc);
        $.ajax({
            url:'replace.php',
            type:'POST',
            data:{
              'oldsrc':oldsrc,
              'newsrc':newsrc,
              '_' : Math.random()
            },
            error:function(){
                
            }
        });
      });
    })(id);

  }
  tmp_img.hide();
};
/*保存事件*/
save_flag = 0;
$('#save-btn').click(function(){
  save_flag = 1;
  $.ajax({
    url: 'update.php',
    dataType: 'json',
    type: 'POST',
    data:{
      'data':cancel_list,
      'action': 'clean',
      '_'   : Math.random()
    },
    success: function(data){
      if(data.status==0){
        $('#save-btn').html('操作完成!');
        setTimeout(function(){
          $('#save-btn').html('保存');
          //location = location;
        }, 200);
      }
    },
    beforeSend: function(){
      $('#save-btn').html('<i class="fa fa-spinner fa-pulse"></i> 正在保存..');
    },
    error: function(){

    }

  });
});

});


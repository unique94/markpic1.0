
jQuery(function($) {'use strict',

cancel_list = {};

/*load pic*/
$.loadPic = function(data, dom){

  function choose(id,rId) {
    if($('#'+id).attr('data') == '0'){
      $('#'+id).css('opacity', 0.4);
      $('#'+id).attr('data','1');
      cancel_list[rId] = 1;
    }else{
      $('#'+id).css('opacity', 1.0);
      $('#'+id).attr('data','0');
      delete cancel_list[rId];
    }
  }

  /*画矩形框*/
  function drawRec(x, y, h, w, id, dom){
    var regiondiv = $('<div class="region"></div>');
    regiondiv.css({'left': x, 'top': y, 'height': h, 'width':w});
    regiondiv.attr('id', id);
    regiondiv.appendTo(dom);
  };

  var scale =1.48, cur_img_div, tmp_img = dom.find('.tmpart') ;
  for(var i = 0; i < data.length; i++){
    var src = data[i][1], id = data[i][0],
        faces = data[i]['region'];


    /*初始化默认face region*/
    var f = 0;
    for(; f < faces.length; f ++){
      cur_img_div = tmp_img.clone();
      cur_img = cur_img_div.find('img')
      cur_img_div.show();
      cur_img.attr('src', src).attr('id', 'r'+f+'i'+id).attr('data', '0');
      cur_img.css('width', data[i]['width']).css('height', data[i]['height']);

      var r = faces[f];
      r['id'] = 'i' + id +'r'+ f;
      r['options'] = 0;
      drawRec(scale * parseInt(r['x']), scale * parseInt(r['y']), scale * parseInt(r['h']), scale*parseInt(r['w']), r['id'], cur_img_div);
      cur_img_div.removeClass('tmpart');
      cur_img_div.appendTo(dom);

      (function(id, rId){
        $('#' + id).click(function(){choose(id,rId)});
        $('#' + r['id']).click(function(){choose(id,rId)});

      })('r'+f+'i'+id, r['regionId']);
    }

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
      'action': 'filter',
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


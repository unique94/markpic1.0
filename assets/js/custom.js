jQuery(function($) {'use strict',

/* 存储face region的全局数组;
* options: 1: 手动修改; 0: 原始region; -1: 撤销;
* regionId: 只有初始的region才有Id,后期写入直接递增;
* 每一个Id的对应列表的首元素为: valid length
* */

region_list = {};

/*load pic*/
$.loadPic = function(data, dom){

  /*画矩形框*/
  function drawRec(x, y, h, w, id, dom){
    var regiondiv = $('<div class="region"></div>');
    regiondiv.css({'left': x, 'top': y, 'height': h, 'width':w});
    regiondiv.attr('id', id);
    regiondiv.appendTo(dom);
  };

  /*jcrop onSelcet 回调*/
	function showCoords(c, id, div, picHeight, faceNum )
	{
    var rec_id = 'i' + id + 'r' + faceNum;
    region_list[id].push({'id':rec_id, 'imgId':id, 'x': c.x, 'y': c.y, 'h': c.h, 'w':c.w, 'options':1});

    $('#i'+id).val(++region_list[id][0]);
    drawRec(c.x, c.y, c.h, c.w, rec_id, div);
	};

	function clearCoords()
	{
	  $('#coords1 input').val('');
	  $('#coords2 input').val('');
	};

  var cur_img_div, tmp_img = dom.find('.tmpart') ;
  for(var i = 0; i < data.length; i++){
    cur_img_div = tmp_img.clone();
    cur_img_div.show();
    var src = data[i][1], id = data[i][0], cur_img = cur_img_div.find('img'),
        faces = data[i]['region'];

    region_list[id] = [0];
    cur_img.attr('src', src).attr('id', id);
    cur_img.css('width', data[i]['width']).css('height', data[i]['height']);


    /*初始化默认face region*/
    var f = 0;
    for(; f < faces.length; f ++){
      var r = faces[f];

      r['id'] = 'i' + id + 'r'+ f;
      r['options'] = 0;
      region_list[id].push(r);
      region_list[id][0] ++;
      drawRec(parseInt(r['x']), parseInt(r['y']), parseInt(r['h']), parseInt(r['w']), r['id'], cur_img_div);
    }
    cur_img_div.find("input").attr('id', 'i' + id).val(f);
    cur_img_div.removeClass('tmpart');
    cur_img_div.appendTo(dom);

    cur_img_div.find('button').attr('id','b' + id);
    /*撤销事件*/
    (function(id){
      $('#b'+id).click(function(){
        var remove_rec = region_list[$(this).attr('id').substr(1)];
        if(remove_rec[0] > 0){
          var cur_len = remove_rec.length - 1;
          while(remove_rec[cur_len]['options'] < 0){
            cur_len --;
          }
          if(typeof remove_rec[cur_len]['regionId'] != 'undefined'){
            if(remove_rec[cur_len]['options'] == 0)
              remove_rec[cur_len]['options'] = -1;
            else
              remove_rec[cur_len]['options'] = -2;
          }
          else
            remove_rec[cur_len]['options'] = -2;
          $('#' + remove_rec[cur_len]['id']).remove();
          $('#i'+id).val(--remove_rec[0]);
        }
      });
    })(id);

    /*jcrop 初始化*/
    var jcrop_api;
    (function(id, div, picHeight){
      cur_img.Jcrop({
        onChange:   function(c){ },
        onSelect:   function(c){ f++;showCoords(c, id, div, picHeight, f)},
        onRelease:  clearCoords
      },function(){
        jcrop_api = this;
      });
    })(id, cur_img_div, parseInt(data[i]['height']));
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
      'data':region_list,
      'action': 'update',
      '_': Math.random()
    },
    success: function(data){
      if(data.status==0){
        $('#save-btn').html('操作完成!');
        setTimeout(function(){
          $('#save-btn').html('保存');
          //location = location;
        }, 200);
      }else{

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


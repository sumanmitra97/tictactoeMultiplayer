function remove_flash() {
  $(".flash").empty();
}
function draw_canvas(canvas) {
  draw_base(canvas);
  load_moves(canvas);
}
function draw_base(canvas) {
  var context = canvas.getContext('2d');
  var canvas_height = canvas.height;
  var canvas_width = canvas.width;
  context.clearRect(0, 0, canvas.width, canvas.height);
  var l_c_1_w = parseInt(canvas_width/3);
  context.lineWidth = (canvas.height*0.04);
  context.strokeStyle = "#f7faff";
  context.beginPath();
  context.moveTo(l_c_1_w, 0);
  context.lineTo(l_c_1_w, canvas_height);
  context.stroke();
  var l_c_2_w = (parseInt(canvas_width/3)*2);
  context.beginPath();
  context.moveTo(l_c_2_w, 0);
  context.lineTo(l_c_2_w, canvas_height);
  context.stroke();
  var l_r_1_h = parseInt(canvas_height/3);
  context.beginPath();
  context.moveTo(0, l_r_1_h);
  context.lineTo(canvas_width, l_r_1_h);
  context.stroke();
  var l_r_2_h = (parseInt(canvas_height/3)*2);
  context.beginPath();
  context.moveTo(0, l_r_2_h);
  context.lineTo(canvas_width, l_r_2_h);
  context.stroke();
}
function load_moves(canvas) {
  var gameid = $("#gameid").val();
  var data = {"gameid": gameid};
  jQuery.ajax({
    url: 'include/load_game.php',
    method: "post",
    data: data,
    success: function(data) {
      var ret = data.split('-');
      if (ret[0] == '0') {
        canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
        $("#notify").empty();
        draw_base(canvas);
      } else if (ret[0] == '1') {
        var moves = ret[1].split(',');
        for (var i = 0; i < moves.length; i++) {
          var move = moves[i].split(':');
          var co_ordinate = get_coordinate(canvas, move[1]);
          if (move[2] == 'x') {
            draw_x(canvas, co_ordinate);
          } else if (move[2] == 'o') {
            draw_o(canvas, co_ordinate);
          }
        }
      } else if (ret[0] == '2') {
        var moves = ret[2].split(',');
        for (var i = 0; i < moves.length; i++) {
          var move = moves[i].split(':');
          var co_ordinate = get_coordinate(canvas, move[1]);
          if (move[2] == 'x') {
            draw_x(canvas, co_ordinate);
          } else if (move[2] == 'o') {
            draw_o(canvas, co_ordinate);
          }
        }
        draw_line(canvas, ret[1]);
      } else if (ret[0] == '3') {
        var moves = ret[1].split(',');
        for (var i = 0; i < moves.length; i++) {
          var move = moves[i].split(':');
          var co_ordinate = get_coordinate(canvas, move[1]);
          if (move[2] == 'x') {
            draw_x(canvas, co_ordinate);
          } else if (move[2] == 'o') {
            draw_o(canvas, co_ordinate);
          }
        }
        $("#notify").html("<strong>Game Draw!</strong>");
      } else if (ret[0] == '9') {
        end_game('profile.php');
      }
    },
    error: function() {
      alert("Something went wrong");
    }
  });
}
function get_coordinate(canvas, grid_index) {
  var context = canvas.getContext('2d');
  var canvas_height = canvas.height;
  var canvas_width = canvas.width;
  var co_ordinate = new Object();
  switch (grid_index) {
    case '1':
      co_ordinate['height'] = canvas_height/6;
      co_ordinate['width'] = canvas_width/6;
      break;
    case '2':
    co_ordinate['height'] = canvas_height/6;
    co_ordinate['width'] = ((((canvas_width/3)*2)-(canvas_width/3))/2)+(canvas_width/3);
      break;
    case '3':
    co_ordinate['height'] = canvas_height/6;
    co_ordinate['width'] = ((canvas_width-((canvas_width/3)*2))/2)+((canvas_width/3)*2);
      break;
    case '4':
    co_ordinate['height'] = ((((canvas_height/3)*2)-(canvas_height/3))/2)+(canvas_height/3);
    co_ordinate['width'] = canvas_width/6
      break;
    case '5':
    co_ordinate['height'] = ((((canvas_height/3)*2)-(canvas_height/3))/2)+(canvas_height/3);
    co_ordinate['width'] = ((((canvas_width/3)*2)-(canvas_width/3))/2)+(canvas_width/3);
      break;
    case '6':
    co_ordinate['height'] = ((((canvas_height/3)*2)-(canvas_height/3))/2)+(canvas_height/3);
    co_ordinate['width'] = ((canvas_width-((canvas_width/3)*2))/2)+((canvas_width/3)*2);
      break;
    case '7':
    co_ordinate['height'] = ((canvas_height-((canvas_height/3)*2))/2)+((canvas_height/3)*2);
    co_ordinate['width'] = canvas_width/6;
      break;
    case '8':
    co_ordinate['height'] = ((canvas_height-((canvas_height/3)*2))/2)+((canvas_height/3)*2);
    co_ordinate['width'] = ((((canvas_width/3)*2)-(canvas_width/3))/2)+(canvas_width/3);
      break;
    case '9':
    co_ordinate['height'] = ((canvas_height-((canvas_height/3)*2))/2)+((canvas_height/3)*2);
    co_ordinate['width'] = ((canvas_width-((canvas_width/3)*2))/2)+((canvas_width/3)*2);
      break;
    default:
      co_ordinate['height'] = co_ordinate['width'] = 0;
  }
  return co_ordinate;
}
function draw_x(canvas, co_ordinate) {
  var grid_height = canvas.height/6;
  var grid_width = canvas.width/6;
  var corner_1 = {"height": (co_ordinate['height']-(grid_height*0.7)), "width": (co_ordinate['width']-(grid_width*0.7))};
  var corner_2 = {"height": (co_ordinate['height']-(grid_height*0.7)), "width": (co_ordinate['width']+(grid_width*0.7))};
  var corner_3 = {"height": (co_ordinate['height']+(grid_height*0.7)), "width": (co_ordinate['width']+(grid_width*0.7))};
  var corner_4 = {"height": (co_ordinate['height']+(grid_height*0.7)), "width": (co_ordinate['width']-(grid_width*0.7))};
  var context = canvas.getContext('2d');
  var line_width = (canvas.height*0.05);
  context.beginPath();
  context.moveTo(corner_1['width'], corner_1['height']);
  context.lineTo((corner_1['width']+line_width), corner_1['height']);
  context.lineTo(corner_3['width'], corner_3['height']);
  context.lineTo((corner_3['width']-line_width), corner_3['height']);
  context.lineTo(corner_1['width'], corner_1['height']);
  context.fillStyle = "white";
  context.fill();
  context.beginPath();
  context.moveTo(corner_2['width'], corner_2['height']);
  context.lineTo((corner_2['width']-line_width), corner_2['height']);
  context.lineTo(corner_4['width'], corner_4['height']);
  context.lineTo((corner_4['width']+line_width), corner_4['height']);
  context.lineTo(corner_2['width'], corner_2['height']);
  context.fillStyle = "white";
  context.fill();
}
function draw_o(canvas, co_ordinate){
  var context = canvas.getContext('2d');
  context.save();
  context.translate(co_ordinate['width'], co_ordinate['height']);
  context.beginPath();
  context.arc(0, 0, (canvas.height*0.12), 0, 2*Math.PI);
  context.fillStyle = "white";
  context.fill();
  context.beginPath();
  context.arc(0, 0, (canvas.height*0.08), 0, 2*Math.PI);
  context.fillStyle = "#414a59";
  context.fill();
  context.restore();
}
function make_move(event) {
  var userid = $("#userid").val();
  var gameid = $("#gameid").val();
  var canvas = document.getElementById("canvas");
  var rect = canvas.getBoundingClientRect();
  var offsetX = event.clientX - rect.left;
  var offsetY = event.clientY - rect.top;
  var grid = get_grid(offsetX, offsetY);
  var data = {"userid": userid, "gameid": gameid, "grid": grid};
  if (grid != 0) {
    jQuery.ajax({
      url: 'include/make_move.php',
      method: "post",
      data: data,
      success: function(data){
        var reply = data.split('-');
        if (reply[0] == 0) {
          $("#notify").text(reply[1]);
        } else if (reply[0] == 1) {
          load_moves(canvas);
        } else if (reply[0] == 2) {
          load_moves(canvas);
        } else if (reply[0] == 3) {
          $("#notify").html("<strong>Game Draw!</strong>");
          load_moves(canvas);
        } else if (reply[0] == 9) {
          end_game('profile.php');
        }
      },
      error: function(){
        alert("Something went wrong");
      }
    });
  }
}
function get_grid(offsetX, offsetY) {
  var canvas = document.getElementById("canvas");
  var context = canvas.getContext('2d');
  var canvas_height = canvas.scrollHeight;
  var canvas_width = canvas.scrollWidth;
  var grid = 0;
  if (((10 < offsetX) && (((canvas_height/3)-10) > offsetX)) && ((10 < offsetY) && (((canvas_width/3)-10) > offsetY))) {
    grid = 1;
  } else if (((10 < offsetX) && (((canvas_height/3)-10) > offsetX)) && ((((canvas_width/3)+10) < offsetY) && ((((canvas_width/3)*2)-10) > offsetY))) {
    grid = 4;
  } else if (((10 < offsetX) && (((canvas_height/3)-10) > offsetX)) && (((((canvas_width/3)*2)+10) < offsetY) && ((canvas_width-10) > offsetY))) {
    grid = 7;
  } else if (((((canvas_height/3)+10) < offsetX) && ((((canvas_height/3)*2)-10) > offsetX)) && ((10 < offsetY) && (((canvas_width/3)-10) > offsetY))) {
    grid = 2;
  } else if (((((canvas_height/3)+10) < offsetX) && ((((canvas_height/3)*2)-10) > offsetX)) && ((((canvas_width/3)+10) < offsetY) && ((((canvas_width/3)*2)-10) > offsetY))) {
    grid = 5;
  } else if  (((((canvas_height/3)+10) < offsetX) && ((((canvas_height/3)*2)-10) > offsetX)) && (((((canvas_width/3)*2)+10) < offsetY) && ((canvas_width-10) > offsetY))) {
    grid = 8;
  } else if ((((((canvas_height/3)*2)+10) < offsetX) && ((canvas_height-10) > offsetX)) && ((10 < offsetY) && (((canvas_width/3)-10) > offsetY))) {
    grid = 3;
  } else if ((((((canvas_height/3)*2)+10) < offsetX) && ((canvas_height-10) > offsetX)) && ((((canvas_width/3)+10) < offsetY) && ((((canvas_width/3)*2)-10) > offsetY))) {
    grid = 6;
  } else if ((((((canvas_height/3)*2)+10) < offsetX) && ((canvas_height-10) > offsetX)) && (((((canvas_width/3)*2)+10) < offsetY) && ((canvas_width-10) > offsetY))) {
    grid = 9;
  }
  return grid;
}
function draw_line(canvas, data) {
  var gru = data.split(':');
  var f_co = get_coordinate(canvas, gru[0]);
  var s_co = get_coordinate(canvas, gru[1]);
  if (gru.length > 2) {
    $("#notify").html("<strong>"+gru[2]+"</strong> wins!");
  }
  if ((gru[0] == 1 && gru[1] == 3) || (gru[0] == 4 && gru[1] == 6) || (gru[0] == 7 && gru[1] == 9)) {
    f_co['width'] = 10;
    s_co['width'] = canvas.width-10;
  } else if ((gru[0] == 1 && gru[1] == 7) || (gru[0] == 2 && gru[1] == 8) || (gru[0] == 3 && gru[1] == 9)) {
    f_co['height'] = 10;
    s_co['height'] = canvas.height-10;
  } else if (gru[0] == 1 && gru[1] == 9) {
    f_co['height'] = f_co['width'] = 10;
    s_co['height'] = s_co['width'] = canvas.height-10;
  } else if (gru[0] == 3 && gru[1] == 7) {
    f_co['height'] = 10;
    f_co['width'] = canvas.width -10;
    s_co['height'] = canvas.height-10;
    s_co['width'] = 10;
  }
  context = canvas.getContext('2d');
  context.beginPath();
  context.moveTo(f_co['width'], f_co['height']);
  context.lineTo(s_co['width'], s_co['height']);
  context.lineWidth = 50;
  context.strokeStyle = '#000000';
  context.stroke();
  context.closePath();
}
function play_again() {
  var gameid = $("#gameid").val();
  var data = {"gameid": gameid};
  jQuery.ajax({
    url: 'include/play_again.php',
    method: 'post',
    data: data,
    success: function() {
      location.reload(true);
    },
    error: function() {
      alert("Something went wrong.");
    }
  });
}
function end_game(loc) {
  var gameid = $("#gameid").val();
  var data = {"gameid": gameid};
  jQuery.ajax({
    url: 'include/end_game.php',
    method: 'post',
    data: data,
    success: function() {
      location.href = loc+'?end='+gameid;
    },
    error: function() {
      alert("Something went wrong.");
    }
  });
}
function choose_avatar(avatar) {
  $("#avatar_input").val(avatar);
  for (var i = 1; i <= 8; i++) {
    if (avatar == i) {
      $("#img_"+avatar).css({"outline": "none", "border-color": "#9ecaed", "box-shadow": "0 0 20px #1d6ef2"});
    } else {
      $("#img_"+i).css({"outline": "none", "border-color": "#000000", "box-shadow": "none"});
    }
  }
}
function load_user(gameid) {
  var data = {"gameid": gameid};
  jQuery.ajax({
    url: 'include/load_user.php',
    method: 'post',
    data: data,
    success: function(data) {
      var reply = data.split('-');
      if (reply[0] == 1) {
        location.reload();
      }
    },
    error: function() {

    }
  });
}

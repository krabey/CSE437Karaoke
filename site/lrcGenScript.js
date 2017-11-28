$(".dropdown-menu li a").click(function(){
  var selText = $(this).text();
  $(this).parents('.btn-group').find('.dropdown-toggle').html(selText+' <span class="caret"></span>');
});

var content = [];
var time = 0;
var timestamps = [];
document.getElementById('startlrc').onclick = function(){

  // By lines
  var lines = document.getElementById('lyricsin').value.split('\n');
  content = document.getElementsByClassName('lyricsout');
  while(content[0].hasChildNodes()) {
    content[0].removeChild(content[0].lastChild);
  }
  for(var l in lines){
    console.log(lines[l]);
    var line = document.createElement("p");
    line.className = 'lyricline';
    var line_text = document.createTextNode(lines[l]);
    if (lines[l] == '') {
      line_text = document.createTextNode('\n');
    }
    line.appendChild(line_text);
    content[0].appendChild(line);

  }
  counter = 0;
  time = Date.now();
  timestamps = [];
  document.getElementsByClassName('lyricscontainer')[0].style.display='block';
  document.getElementById('lyricsin').style.display='none';
  document.getElementById('nextlrc').disabled= false;
  document.getElementsByClassName('lyricline')[0].style.backgroundColor='yellow';
};

//add a timer
var nextlrc = document.getElementById('nextlrc');
nextlrc.addEventListener('click', nextline, false);
document.getElementById('stoplrc').addEventListener('click', stop, false);

var timerOn = false;
var counter = 0;
var prevline = 0;
var t;

var index = 1;
var first = true;


function nextline() {
  //highlight text according to time
  var lines = document.getElementsByClassName('lyricline');
  while(lines[counter].innerHTML == '\n') {
    counter++;
    if(typeof(lines[counter]) == 'undefined') {
      submit();
      return;
    }
  }

  if(counter >= 11) {
    document.getElementsByClassName('lyricsout')[0].scrollTop += 25;
  }
  var stamp = (Date.now()-time);
  console.log(Date.now()-time);
  var stamp2 = Math.floor(stamp/60000);
  stamp2 = ('00'+stamp2).slice(-2);
  var addto = '[' + stamp2 + ':';
  stamp = stamp % 60000;
  stamp = Math.floor(stamp/10);
  stamp = ('0000'+stamp).slice(-4);
  addto += stamp.substring(0,2) + '.' + stamp.substring(2,4) + ']';
  timestamps.push(addto + lines[counter].innerHTML);

  lines[counter].innerHTML = addto + lines[counter].innerHTML;
  lines[counter].style.backgroundColor = "transparent";

  prevline = counter;
  counter++;
  if(counter >= lines.length) {
    submit();
    return;
  }
}

function stop() {
  document.getElementsByClassName('lyricscontainer')[0].style.display='none';
  document.getElementById('lyricsin').style.display='block';
  document.getElementById('nextlrc').disabled= true;
}

function submit() {
  if (confirm("submit lyrics?") == true) {
    var header = [];
    header.push('[ti:' + document.getElementById('title').value + ']');
    header.push('[ar:' + document.getElementById('artist').value + ']');
    header.push('[al:' + document.getElementById('album').value + ']');
    header.push('[au:' + document.getElementById('author').value + ']');
    header.push('[la:' + document.getElementById('language').value + ']');
    header.push('[re:KaraokeIt]');
    $.ajax({
      data: { title: header[0], artist: header[1], album: header[2], author: header[3], language: header[4], lyrics: timestamps},
      url: 'writelyrics.php',
      method: 'POST', // or GET
      success: function(msg) {
        alert('lyrics uploaded!');
      }
    });
  }
  stop();
}

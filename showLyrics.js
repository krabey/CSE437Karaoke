var times = [];
document.getElementById('file').onchange = function(){

  var file = this.files[0];

  var reader = new FileReader();
  reader.onload = function(progressEvent){
    // Entire file
    console.log(this.result);

    // By lines
    var lines = this.result.split('\n');
    var content = document.getElementsByClassName('content');
    while(content[0].hasChildNodes()) {
      content[0].removeChild(content[0].lastChild);
    }
    for(var l in lines){
      console.log(lines[l]);
      var line = document.createElement("p");
      var line_text = document.createTextNode(lines[l]);
      line.appendChild(line_text);
      content[0].appendChild(line);

      var nextup = lines[l].slice(1,9);
      var mins = parseInt(nextup.slice(0,2));
      var secs = parseInt(nextup.slice(3,5));
      var mils = parseInt(nextup.slice(6,8));
      if(l != 0){
        var sum = times.reduce(add, 0);
        var nextTime = (mins*60000+secs*1000+mils*10)-(sum);
        console.log(nextTime);
        console.log(times[l-1]);
        times.push(nextTime)
      }
      else{
        times.push(mins*60000+secs*1000+mils*10);
      }
    }
    console.log(times);
  };
  reader.readAsText(file);
};

//add a timer
var start_btn = document.getElementById('start_btn');
start_btn.addEventListener('click', start, false);
document.getElementById('stop_btn').addEventListener('click', stop, false);

var timerOn = false;
var counter = 0;
var t;

var index = 1;
var first = true;
function start() {
  //if (!timerOn) {
    timerOn = true;
    //timerStart();
    console.log(times[index]);
    if (first == true){
      //timerStart();
      t = setTimeout(timerStart, times[index] + times[index-1]);
      first = false;
    }
    else{
      t = setTimeout(timerStart, times[index]);  
    }
    index++;
  //}
}

function stop() {
  timerOn = false;
  //clearInterval(t);
}

function timerStart() {
  document.getElementById('timer').innerHTML = counter;
  //highlight text according to time
  var lines = document.getElementsByTagName('p');
  lines[counter].style.backgroundColor = "yellow";
  if (counter >= 1) {
    lines[counter - 1].style.backgroundColor = "transparent";
  }
  counter++;
  start();
}

function add(a, b) {
    return a + b;
}
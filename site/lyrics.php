<html>
<head>
  <title>Karaoke Lyrics and Generator</title>

  <!-- Latest compiled CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous"></link>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"></link>
  <link rel="stylesheet" href="site.css"></link>

</head>

<body>

    <header>
      <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="index.html">KaraokeIt</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="index.html">Home </a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="lyrics.php">Lyrics <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="lrcGen.html">LRC Generator </a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="contact.html">Contact </a>
            </li>
          </ul>
          <form class="form-inline mt-2 mt-md-0">
            <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
        </div>
      </nav>
    </header>

    <main role="main">

        <div class="container">
          <div class="row">
            <div id='filters' class="col-sm-10">
              <hr>
      			  <a href='?filter=a'>A</a>
      			  <a href='?filter=b'>B</a>
      			  <a href='?filter=c'>C</a>
      			  <a href='?filter=d'>D</a>
      			  <a href='?filter=e'>E</a>
      			  <a href='?filter=f'>F</a>
      			  <a href='?filter=g'>G</a>
      			  <a href='?filter=h'>H</a>
      			  <a href='?filter=i'>I</a>
      			  <a href='?filter=j'>J</a>
      			  <a href='?filter=k'>K</a>
      			  <a href='?filter=l'>L</a>
      			  <a href='?filter=m'>M</a>
      			  <a href='?filter=n'>N</a>
      			  <a href='?filter=o'>O</a>
      			  <a href='?filter=p'>P</a>
      			  <a href='?filter=q'>Q</a>
      			  <a href='?filter=r'>R</a>
      			  <a href='?filter=s'>S</a>
      			  <a href='?filter=t'>T</a>
      			  <a href='?filter=u'>U</a>
      			  <a href='?filter=v'>V</a>
      			  <a href='?filter=w'>W</a>
      			  <a href='?filter=x'>X</a>
      			  <a href='?filter=y'>Y</a>
      			  <a href='?filter=z'>Z</a>
              <button id='start_btn' type="button">Start</button>
              <button id='stop_btn' type="button">Stop</button>
              </div>
              <div id='big'>
              <div id='songstable'>
              <table class="table">
                <tbody class="tableitems">
                  <th>Artist</th>
                  <th>Song</th>
                    <?php
                      $handle = opendir('/home/g3/');

                      if($handle){
                          while(($entry = readdir($handle)) !== false){
                              if($entry != '.' && $entry != '..' && $entry != '.htaccess' && substr( $entry, 0, 1 ) != "."){
                                if(!empty($_GET['filter'])){
                                  $dataf = $_GET['filter'];
                                  if (substr($entry, 0, 1) != $dataf) {
                                    continue;
                                  }
                                }

                                $lya = substr(explode("-", $entry, 2)[1], 0, -4);
                                $lys = explode("-", $entry, 2)[0];
                                echo "<tr><td><a href=\"lyrics.php?file=$entry\">$lya</a></td><td><a href=\"lyrics.php?file=$entry\">$lys</a></td></tr>";
                              }
                          }
                          closedir($handle);
                      }
                    ?>
                </tbody>
              </table>
              </div>
              <div id="displaylyrics">

                <?php
                if(!empty($_GET['file'])){
                  $data = $_GET['file'];
                  $my_file = fopen('/home/g3/'.$data, "r") or die("file not found");
                  $fileread = fread($my_file, filesize("/home/g3/".$data));
                  echo "<p class=\"it\">".str_replace("\n", "</p><p class=\"it\">", $fileread);
                  fclose($my_file);
                }
                ?>


                <script>
                var times = [];
                var lines = document.getElementsByClassName('it');
                for(var l in lines){
                  console.log(lines[l]);
                  if(typeof lines[l].innerHTML == 'undefined') {
                    break;
                  }
                  var nextup = lines[l].innerHTML.slice(1,9);
                  var mins = parseInt(nextup.slice(0,2));
                  var secs = parseInt(nextup.slice(3,5));
                  var mils = parseInt(nextup.slice(6,8));
                  if(l != 0){
                    var sum = times.reduce(add, 0);
                    var nextTime = (mins*60000+secs*1000+mils*10)-(sum);
                    console.log(nextTime);
                    console.log(times[l-1]);
                    times.push(nextTime);
                  }
                  else{
                    times.push(mins*60000+secs*1000+mils*10);
                  }
                }

                function add(a, b) {
                    return a + b;
                }

                //add a timer
                var start_btn = document.getElementById('start_btn');
                start_btn.addEventListener('click', start, false);
                document.getElementById('stop_btn').addEventListener('click', stop, false);

                var timerOn = false;
                var counter = 0;
                var t;

                var index = 0;
                var first = true;
                function start() {
                  //if (!timerOn) {
                    timerOn = true;
                    //timerStart();
                    console.log(times[index]);
                    if (first == true){
                      //timerStart();
                      t = setTimeout(timerStart, times[index]);
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
                  //highlight text according to time

                  var lines = document.getElementsByClassName('it');
                  if(typeof lines[counter] == 'undefined') {
                    return;
                  }
                  lines[counter].style.backgroundColor = "yellow";
                  if (counter >= 1) {
                    lines[counter - 1].style.backgroundColor = "transparent";
                  }
                  counter++;
                  start();
                }
                </script>
              </div>
            </div>
          </div>
        </div>



      <!-- FOOTER -->
      <footer class="container">
        <p class="float-right"><a href="#">Back to top</a></p>
        <p>&copy; 2017 Eddy Yu, Jason Wang, Chuanqi Shi. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
      </footer>

    </main>


    <!-- Latest compiled JavaScript -->
    <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <script src="getsongs.js"></script>
  </body>
</html>

<?php
if(!empty($_POST['lyrics'])){
  $data = $_POST['lyrics'];
  if ( is_array( $data ) ) {
        $data = implode( "\n", $data);
  }
  $my_file = '/home/g3/'.substr(str_replace(' ', '_', $_POST['title']), 4, -1).'-'.substr(str_replace(' ', '_', $_POST['artist']), 4, -1).'.lrc';
  $counter = 1;
  $going = false;
  $a_file = $my_file;
  while (file_exists($a_file)){
    $a_file = $myfile.$counter;
    $counter++;
    $going = true;
  }
  if ($going) {
    $my_file = substr($my_file, 0, -4).'('.$counter.')'.'.lrc';
  }
  $handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file); //implicitly creates file
  fwrite($handle, $data);
}
?>

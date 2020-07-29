<?php 

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT");
header("Access-Control-Allow-Headers: content-type,append,delete,entries,foreach,get,has,keys,set,values,Authorization");

function endsWith( $haystack, $needle ) {
  $length = strlen( $needle );
  if( !$length ) {
      return true;
  }
  return substr( $haystack, -$length ) === $needle;
}

// adding the path within the request is enough to make removal secure, since filenames are randomly generated with an md5 hash.
// filepath must end with .mp3 as that is what this audio API stores. (this is partly for security)
// IMPORTANT: make sure the user cannot delete files outside the files/ directory. This is imperative in terms of security; if someone finds a way to inject 
if($_GET && isset($_GET['filepath'])) {
  $filepath = $_GET['filepath'];

  // remove all spaces and quotations (" and ')
  str_replace(' ', '', $filepath);
  str_replace('"', '', $filepath);
  str_replace("'", '', $filepath);

  if(endsWith($filepath, '.mp3')) {
    $files_list = scandir('files/');
    $valid_file = false;
    
    foreach ($files_list as $key => $value) {
      if($value != '.' && $value != '..') {
        $curfilepath = 'files/' . $value;
        if($curfilepath == $filepath) {
          // in files list, so it is a valid file
          $valid_file = true;
        }
      }
    }
  
    if($valid_file == true) {
      shell_exec("rm '" . $_GET['filepath'] . "'");
      echo "Success";    
    } else {
      echo "Error: filepath either does not exist or is not in files/ directory.";
    }
  } else {
    echo "File must be a .mp3 file.";
  }
} else {
  echo "Error: filepath not provided.";
}


?>
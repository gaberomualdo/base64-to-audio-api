<?php 

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT");
header("Access-Control-Allow-Headers: content-type,append,delete,entries,foreach,get,has,keys,set,values,Authorization");

// adding the path within the request is enough to make removal secure, since filenames are randomly generated with an md5 hash.
if($_GET && $_GET['filepath']) {
  shell_exec('rm ' . $_GET['filepath']);
  echo "Success";
}

echo "Error: filepath not provided.";

?>
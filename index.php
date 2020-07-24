<?php
/*
This server takes a base64 string as a POST variable, and creates
an audio file from that base64 string, and returns the relative URL of 
that generated audio file.
*/

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT");
header("Access-Control-Allow-Headers: content-type,append,delete,entries,foreach,get,has,keys,set,values,Authorization");

// function to convert base64 to audio and put in file
function base64_to_file( $base64_string, $output_file ) {
    $ifp = fopen( $output_file, "wb" ); 
    fwrite( $ifp, base64_decode( $base64_string) ); 
    fclose( $ifp ); 
    return( $output_file ); 
}

// unique ID for audio file name
$raw_id = uniqid();
$id = hash('sha256', $raw_id);

// file path (all generated files are in files/ directory)
$filepath_no_ext = "files/" . $id;
$file_ext = '.wav';

// convert given base64 to audio and store in generated file path
$request_data = json_decode(file_get_contents('php://input'), true);
base64_to_file($request_data["fileContents"], $filepath_no_ext . $file_ext);

// now, convert .wav file to .mp3 with ffmpeg cli
$new_file_ext = '.mp3';
shell_exec("ffmpeg -i " . ($filepath_no_ext . $file_ext) . " -vn -ar 44100 -ac 2 -b:a 192k ./" . ($filepath_no_ext . $new_file_ext));
shell_exec("rm " . ($filepath_no_ext . $file_ext));

// set content type to txt
header("Content-Type: text/plain");

// return file path in JSON
$final_file_path = $filepath_no_ext . $new_file_ext;
echo '{ "filePath": "' . $final_file_path . '" }';
?>
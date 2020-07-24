# base64-to-audio-api
Converts Base64 .wav representation of a file to an absolute, public .mp3 file path.

## Usage

### POST: `/`

With JSON body data:

```json
{
    fileContents: "[file base64 here]"
}
```

Note: Base64 does NOT include the 'data:type=' part of a data URI, only the Base64 content. To remove this beginning part, simply split the text with the ',' delimeter and use only the last part.

Returns JSON like this:

```json
{
	"filePath": "[filepath here, RELATIVE to server base]"
}
```

Filepath conversion from relative to absolute URLs is done yourself by prefixing the server base URL (prefix includes a trailing '/' at the end).

The returned filepath will be an .mp3 file with the audio contents of the posted base64.

### GET `/remove_file.php?filepath=[filepath here]`

Remove a file to save storage. Filepath should be the same as the one returned with the `/` POST request.

Filepath is relative and does not include a '/' at the beginning.


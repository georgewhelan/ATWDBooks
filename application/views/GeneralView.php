<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

header('Content-type: ' . $header);
// Echo out the Header so the browser knows what type of document it is.

echo $result;
// Echo the result (either JSON or XML).

?>
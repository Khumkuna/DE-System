<?php
// Report all errors except notices and warnings
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

// Alternatively, show ONLY fatal errors
error_reporting(E_ERROR | E_PARSE);

// Turn off ALL error reporting (not recommended for development)
error_reporting(0);

?>
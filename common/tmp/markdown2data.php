<?php

define("ROOT", getcwd() . "/../");
include "../framework/functions.php";

$docs = (object) array(
"chapters" => markdown('- Introduction
  - Overview
  - Goals
- Usage
  - Installation
  - Configuration
- Examples
  - Example 1
  - Example 2
- Conclusion')
);

?>

// Example usage
<pre><? var_dump(markdown_decode($docs->chapters)); ?></pre>
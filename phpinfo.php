<?php
echo in_array('mod_rewrite', apache_get_modules()) ? "enabled" : "nahh";
echo '<br />';
phpinfo();
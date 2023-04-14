<?php
foreach(get_loaded_extensions() as $extension)
{
    echo $extension.'<br/>';
}
phpinfo();

<?php
function upgrade_2022101301()
{
    add_option_if_not_exists('updated', 'true');
}

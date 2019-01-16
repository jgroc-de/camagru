<?php

/**
 * write flash message stored in $_SESSION['flash']
 */
function flashMessage()
{
    if (isset($_SESSION['flash']))
    {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        foreach ($flash as $key => $value)
        {
            switch ($key)
            {
            case 'fail':
                echo '<p class="flash" style="background:#f9ccca">';
                break;
            case 'success':
                echo '<p class="flash" style="background:#b6e5af">';
                break;
            default:
                echo '<p class="flash" style="background:#f9ccca">';
            }
            echo $value . '</p>';
        }
    }
}

<?php
    if (isset($succcess_mes))
    {
        foreach ($succcess_mes as $succcess_mes)
            echo '<script>swal("'.$succcess_mes.'", "", " success");</script>';
    }

    if (isset($warning_mess))
    {
        foreach ($warning_mess as $warning_mess)
            echo '<script>swal("'.$warning_mess.'", "", " success");</script>';
    }

    if (isset($info_mess))
    {
        foreach ($info_mess as $info_mess)
            echo '<script>swal("'.$info_mess.'", "", " success");</script>';
    }

    if (isset($error_mess))
    {
        foreach ($error_mess as $error_mess)
            echo '<script>swal("'.$error_mess.'", "", " success");</script>';
    }
?>
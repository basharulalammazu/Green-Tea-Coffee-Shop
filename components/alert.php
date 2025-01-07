<?php
    if (isset($succcess_msg)) {
        foreach ($succcess_msg as $msg)
            echo '<script>Swal.fire("'.$msg.'", "", "success");</script>';
    }

    if (isset($warning_msg)) {
        foreach ($warning_msg as $msg)
            echo '<script>Swal.fire("'.$msg.'", "", "warning");</script>';
    }

    if (isset($info_msg)) {
        foreach ($info_msg as $msg)
            echo '<script>Swal.fire("'.$msg.'", "", "info");</script>';
    }

    if (isset($error_msg)) {
        foreach ($error_msg as $msg) {
            // Ensure $msg is converted to a string
            $message = is_array($msg) ? implode(', ', $msg) : $msg;
            echo '<script>Swal.fire("'.$message.'", "", "error");</script>';
        }
    }
    
?>

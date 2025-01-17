<?php
if (isset($succcess_msg)) {
    foreach ($succcess_msg as $msg) {
        if (is_array($msg)) {
            $msg = implode(', ', $msg); // Convert array to string if $msg is an array
        }
        // Check if we need to redirect to dashboard.php after a success message (only used in add_products rn after adding products)
        if (isset($redirect_to_dashboard) && $redirect_to_dashboard === true) {
            echo '<script>
                Swal.fire({
                    title: "'.$msg.'",
                    icon: "success",
                    confirmButtonText: "Okay"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "dashboard.php";
                    }
                });
            </script>';
        } else {
            echo '<script>Swal.fire("'.$msg.'", "", "success");</script>';
        }
    }
}

if (isset($warning_msg)) {
    foreach ($warning_msg as $msg) {
        if (is_array($msg)) {
            $msg = implode(', ', $msg); // Convert array to string if $msg is an array
        }
        echo '<script>Swal.fire("' . $msg . '", "", "warning");</script>';
    }
}

if (isset($info_msg)) {
    foreach ($info_msg as $msg) {
        if (is_array($msg)) {
            $msg = implode(', ', $msg); // Convert array to string if $msg is an array
        }
        echo '<script>Swal.fire("' . $msg . '", "", "info");</script>';
    }
}

if (isset($error_msg)) {
    foreach ($error_msg as $msg) {
        if (is_array($msg)) {
            $msg = implode(', ', $msg); // Convert array to string if $msg is an array
        }
        echo '<script>Swal.fire("' . $msg . '", "", "error");</script>';
    }
}
?>

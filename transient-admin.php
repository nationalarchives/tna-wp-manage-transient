<?php
/**
 * Transient admin page
 *
 */

include 'functions.php';

function tna_transient_add_menu_item() {
    add_options_page('Transient admin', 'Manage transients', 'manage_options', 'tna-transient-admin', 'tna_transient_admin_page', null, 99);
}

function tna_transient_admin_page() {
    var_dump(get_expired_transients());
    ?>
    <style>
        .tna-transient-admin input[type=text], .tna-transient-admin textarea {
            width: 100%;
            max-width: 480px;
            height: 130px;
        }
        .tna-transient-admin .dash-frame {
            border: 1px solid #ddd;
            padding: 1em;
            background-color: #fff;
            max-width: 576px;
        }
        .tna-transient-admin p {
            margin: 1em 0;
        }
    </style>
    <div class="wrap tna-transient-admin">
        <h1>Manage transients</h1>
        <hr>


        <hr>
    </div>
    <?php
}
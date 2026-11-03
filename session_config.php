<?php
session_name("MesNotes");


session_set_cookie_params([
    'lifetime'=>3600,
    'path'=> '/',
    'httponly'=> true,
    'samesite'=>'Lax'
]);
session_start();
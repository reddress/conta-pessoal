<?php
session_start();
require("dbhost.php");

function set_session($uid) {
    $_SESSION['uid'] = $uid;
}

function save_cookie($uid) {
    $rand = date("YmdHis") . bin2hex(random_bytes(26));
    $insert_sql = $dbh->prepare("insert into autologin (rand, dono) values (:rand, :uid)");
    $insert_sql->execute([":rand" => $rand, ":uid" => $uid]);

    setcookie("autologin", $rand);
}

function delete_cookie($rnd) {
    $delete_sql = $dbh->prepare("delete from autologin where rand = :rand");
    $delete_sql->execute([":rand" => $rand]);
    setcookie("autologin", "", time() - 3600);
}

function read_cookie() {
    // set_session if a valid cookie exists
    
}

<?php
require("dbhost.php");

function set_session($uid) {
    // called at the end of save_cookie($uid)
    $_SESSION['uid'] = $uid;
}

function save_cookie($dbh, $uid) {
    $rand = date("YmdHis") . bin2hex(random_bytes(16));
    $insert_sql = $dbh->prepare("insert into autologin (rand, dono) values (:rand, :uid)");
    $insert_sql->execute([":rand" => $rand, ":uid" => $uid]);

    setcookie("autologin", $rand, time() + 3600*24*365);
    set_session($uid);
}

function delete_cookie($dbh, $rand) {
    session_unset();
    $delete_sql = $dbh->prepare("delete from autologin where rand = :rand");
    $delete_sql->execute([":rand" => $rand]);
    setcookie("autologin", "", time() - 3600);
}

function read_cookie($dbh) {
    // set_session if a valid cookie exists
    if (isset($_COOKIE['autologin'])) {
        $get_uid_sql = $dbh->prepare("select dono from autologin where rand = :rand");
        $get_uid_sql->execute([":rand" => $_COOKIE['autologin']]);
        $uid_row = $get_uid_sql->fetch();
        set_session($uid_row['dono']);
    }
}

// check if a cookie exists to grant access and display username
read_cookie($dbh);

$username = "anônimo";

if (isset($_SESSION['uid'])) {
    $user_sql = $dbh->prepare("select nome from usuarios where id = :uid");
    $user_sql->execute([":uid" => $_SESSION['uid']]);
    $user_row = $user_sql->fetch();

    $username = $user_row['nome'];
}

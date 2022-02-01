<?php
    $kode = $_GET['kode'];
    $username = $_GET['username'];
 
    $koneksi=mysql_connect('localhost','root','');
    mysql_select_db('untuk_blog',$koneksi);
 
    $query = mysql_query("UPDATE verifikasi_email SET aktif = 'Y' WHERE kode = '".$kode."'") or die (mysql_error());
 
    if($query) {
        echo "Member dengan username <strong>".$username."</strong> telah diaktifkan";
    } else {
        echo "Gagal diaktifkan";
    }
?>

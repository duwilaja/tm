<?php
session_start(); //Memulai session
$width = 100; //Ukuran lebar
$height = 20; //Tinggi
$im = imagecreate($width, $height);
$bg = imagecolorallocate($im, 240, 240, 240);
$len = 6; //Panjang karakter
$chars = '123456789abcdefghijklmnopqrstuvwxyz'; //Kombinasi huruf dan angka yang diacak
$string = '';
for ($i = 0; $i < $len; $i++) {
    $pos = rand(0, strlen($chars)-1);
    $string .= substr($chars,$pos,1);
}
$_SESSION['kode_captcha'] = $string; //hasil acak disimpan dalam variabel session
//menambahkan titik2 gambar / noise
$bgR = mt_rand(100, 200); $bgG = mt_rand(100, 200); $bgB = mt_rand(100, 200);
$noise_color = imagecolorallocate($im, abs(255 - $bgR), abs(255 - $bgG), abs(255 - $bgB));
for($i = 0; $i < ($width*$height) / 3; $i++) {
    imagefilledellipse($im, mt_rand(0,$width), mt_rand(0,$height), 2, rand(2,3), $noise_color);
}
// proses membuat tulisan
$text_color = imagecolorallocate($im, $bgR, $bgG, $bgB);
$rand_x = rand(0, $width - 50);
$rand_y = rand(0, $height - 15);
imagestring($im, 12, $rand_x, $rand_y, $string, $text_color);
header ("Content-type: image/png"); //Output format gambar
imagepng($im);
?>
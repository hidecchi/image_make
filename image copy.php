<?php

ini_set('display_errors', "On");
//ヘッダーの設定
header("Content-type: image/jpeg");



// 文字列を挿入する先の画像
$file = "./tt.jpg";

// 出力後のファイル名
$newfile = "tt_maoji.jpg";

// コピー先画像作成
$image = imagecreatefromjpeg($file);

// 挿入する文字列
// $text = wordwrap($origin_text, 5, ',', true);
$text = "aaa";
$text = ["ああああ", "いいいいいい", "ええええええ"];

// 挿入する文字列のフォント(今回はWindowsに入ってたメイリオを使う)
$fontfile = "C:\Windows\Fonts\meiryo.ttc";

// 挿入する文字列の色(白)
$color = imagecolorallocate($image, 255, 255, 255);

// 挿入する文字列のサイズ(ピクセル)
$fontsize = 13;
$margin = 10;

//背景用画像のサイズを取得する
$filesize = getimagesize($file);
$filew = $filesize[0];
$fileh = $filesize[1];

//テキストが合計何行になるかによって開始位置を設定（上下中央に持ってくるため）
$count = count($text); //行数を計算
$height = ($fontsize + $margin) * $count; //テキスト部分の高さを計算

//テキスト開始位置。-10はbaseline分ですが、結果を見ながら目分量で調整する必要がありそう。
$y = (($fileh - $height) / 2);

//文字一行ずつ出力していく
foreach ($text as $val) {
    //文字エリアの座標を取得する関数です
    $pos = imagettfbbox($fontsize, 0, $fontfile, $val);

    //左右中央に持ってくるため、(画像幅-文字幅)/2を開始位置とします。
    $x = ($filew - ($pos[4] - $pos[6])) / 2;

    //imagettftextで実際に文字を生成する
    imagettftext($image, $fontsize, 0, $x, $y, $color, $fontfile, $val);

    //縦方向の位置を文字サイズ＋行間分ずらす（これでline-height:2ぐらいになるはず）
    $y = $y - ($pos[7] - $pos[1]) + $margin + $fontsize;
}

// // 挿入する文字列の角度
// $angle = 0;

// // 挿入位置
// $x = 10;         // 左からの座標(ピクセル)
// $y = 10 + $size; // 上からの座標(ピクセル)

// // 文字列挿入
// imagettftext(
//     $image,     // 挿入先の画像
//     $size,      // フォントサイズ
//     $angle,     // 文字の角度
//     $x,         // 挿入位置 x 座標
//     $y,         // 挿入位置 y 座標
//     $color,     // 文字の色
//     $fontfile,  // フォントファイル
//     $text
// );     // 挿入文字列

// ファイル名を指定して画像出力
imagejpeg($image);

imagedestroy($image);

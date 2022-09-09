<?php
ini_set('display_errors', "On");
//ヘッダーの設定
header("Content-type: image/jpeg");

function mb_wordwrap($str, $width = 15, $break = PHP_EOL, $encode = "UTF-8")
{
    $count = mb_strlen($str, $encode);
    $count > 45 ? $count = 45 : "";
    $array = [];
    for ($i = 0; $i <= $count; $i += $width) {
        array_push($array, mb_substr($str, $i, $width, $encode));
    }
    return  $array;
}
$textArray = [];
if (isset($_GET["text"])) {
    $textArray  = mb_wordwrap($_GET["text"]);
}

// 文字列を挿入する先の画像
$file = "./sample.jpg";

// 出力後のファイル名
$newfile = "sample_maoji.jpg";

// コピー先画像作成
$image = imagecreatefromjpeg($file);

$fontFile = dirname(__FILE__) . "/font/NotoSansJP-Medium.otf";

// 挿入する文字列の色(白)
$color = imagecolorallocate($image, 255, 255, 255);

// 挿入する文字列のサイズ(ピクセル)
$fontSize = 22;
$margin = 10;

//背景用画像のサイズを取得する
$filesize = getimagesize($file);
$filew = $filesize[0];
$fileh = $filesize[1];

//テキストが合計何行になるかによって開始位置を設定（上下中央に持ってくるため）
$count = count($textArray); //行数を計算
$height = ($fontSize + $margin) * $count; //テキスト部分の高さを計算

//テキスト開始位置。-10はbaseline分ですが、結果を見ながら目分量で調整する必要がありそう。
$y = (($fileh - $height) / 2);

//文字一行ずつ出力していく
foreach ($textArray as $text) {
    //文字エリアの座標を取得する関数です
    $pos = imagettfbbox($fontSize, 0, $fontFile, $text);

    //左右中央に持ってくるため、(画像幅-文字幅)/2を開始位置とします。
    $x = ($filew - ($pos[4] - $pos[6])) / 2;

    //imagettftextで実際に文字を生成する
    imagettftext($image, $fontSize, 0, $x, $y, $color, $fontFile, $text);

    //縦方向の位置を文字サイズ＋行間分ずらす（これでline-height:2ぐらいになるはず）
    $y = $y - ($pos[7] - $pos[1]) + $margin + $fontSize;
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

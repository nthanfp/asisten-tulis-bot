<?php
require('./lib/config.php');
require('./vendor/autoload.php');

use Intervention\Image\ImageManagerStatic as Image;

$telegram = new Telegram($config['telegram_token']);
$telegram->deleteWebhook();

do {
	sleep(1);
	$req = $telegram->getUpdates();
	if ($req['ok']) {
		//echo "Okey\n";
		for ($i = 0; $i < $telegram->UpdateCount(); $i++) {
			$telegram->serveUpdate($i);
			$text		= $telegram->Text();
			$chat_id	= $telegram->ChatID();
			$msg_id 	= $telegram->MessageID();
			$username	= $telegram->Username();
			$datex		= $telegram->Date();
			$date		= date('Y-m-d H:i:s', $datex);
			$time		= time();
			$temp		= "[" . date('Y-m-d H:i:s') . "][" . $date . "][" . $msg_id . "][" . $chat_id . "][" . $username . "] => " . $text . "\n";
			file_put_contents('history.log', $temp, FILE_APPEND);
			mysqli_query($conn, "INSERT INTO `tbl_message` (`id_message`, `date`, `chat_id`, `username`, `text`, `created_at`) VALUES ('$msg_id', '$datex', '$chat_id', '$username', '$text', '$time')");
			echo $temp;
			if ($text == '/start') {
				$reply 		= "Haloo kak! Ini dengan bot Asisten Tulis. Apakah ada yang bisa dibantu kak? Jika membutuhkan bantuan silahkan ketik /help ya kak";
				$content 	= ['chat_id' => $chat_id, 'text' => $reply];
				$telegram->sendMessage($content);
			} else if ($text == '/help') {
				$reply 		= "Fitur:\n/tulis1 {KALIMAT} = Untuk menulis di kertas dengan buku biasa\n/tulis2 {KALIMAT} = Untuk menulis di kertas HVS\n/tulis3 {KALIMAT} = Untuk menulis di kertas folio\n\nCatatan:\n- Ganti {KALIMAT} beserta tanda { } dengan kalimat yang kamu ingin tuliskan\n- Untuk menulis dengan garis baru atau paragraf baru bisa menggunakan ENTER\n- Dilarang menulis menggunakan emoji\n- Jika bot ini error atau ada kendala silahkan menghubungi kami dengan ketik /contact\n\nBot ini dibuat dengan \xE2\x9D\xA4 oleh @nthanfp";
				$content 	= ['chat_id' => $chat_id, 'text' => $reply];
				$telegram->sendMessage($content);
			} else if (strpos($text, '/tulis1') !== false) {
				$text 		= explode('/tulis1', $text)[1];
				$text		= trim($text);
				$reply 		= "Mohon ditunggu ya kak dan jangan spam yaa :)";
				$content 	= ['chat_id' => $chat_id, 'text' => $reply];
				$telegram->sendMessage($content);
				$image_name 	= __DIR__ . '/assets/img/kertas-buku2.jpg';
				$font_name 		= __DIR__ . '/assets/font/my_handwriting/My_handwriting.ttf';
				$random 		= 'hasil-' . time() . '-' . rand(100, 999);
				$export_name 	= __DIR__ . '/output/' . $random . '.jpg';
				$width       	= 600;
				$height      	= 800;
				$center_x    	= $width / 2;
				$center_x 		= 127;
				$center_y    	= 90;
				$max_len     	= 72;
				$font_size   	= 25;
				$font_height 	= 21;
				$lines 			= explode("\n", wordwrap($text, $max_len));
				$y     			= $center_y - ((count($lines) - 1) * $font_height);
				$y 				= ($y < $center_y) ? $y + ($center_y - ($y)) : $y;
				$count 			= (count($lines) > 31) ? 31 : count($lines);
				$img 			= Image::make($image_name);
				for ($i = 0; $i < $count; $i++) {
					$img->text($lines[$i], $center_x, $y, function ($font) {
						global $font_size;
						global $font_name;
						$font->file($font_name);
						$font->size($font_size);
						$font->color('#000000');
						$font->align('left');
					});
					//echo $i.". ".$center_x.", ".$y." ".$font_height." => ".$lines[$i]."<br>";
					$font_height = ($i == 7) ? $font_height + 1 : $font_height;
					$font_height = ($i == 9) ? $font_height - 1 : $font_height;
					$font_height = ($i == 23) ? $font_height + 1 : $font_height;
					$y += $font_height * 1;
				}
				$img->text(date('d-m-Y'), 455, 45, function ($font) {
					global $font_size;
					global $font_name;
					$font->file($font_name);
					$font->size($font_size);
					$font->color('#000000');
					$font->align('left');
				});
				$img->save($export_name);
				$nulis 		= $random;
				$file 		= './output/' . $nulis . '.jpg';
				$img 		= curl_file_create($file, 'image/jpeg');
				$content 	= array('chat_id' => $chat_id, 'photo' => $img);
				$telegram->sendPhoto($content);
				unlink($file);
			} else if (strpos($text, '/tulis2') !== false) {
				$text 		= explode('/tulis2', $text)[1];
				$text		= trim($text);
				$reply 		= "Mohon ditunggu ya kak dan jangan spam yaa :)";
				$content 	= ['chat_id' => $chat_id, 'text' => $reply];
				$telegram->sendMessage($content);
				$image_name 	= __DIR__ . '/assets/img/hvs.jpg';
				$font_name 		= __DIR__ . '/assets/font/my_handwriting/My_handwriting.ttf';
				$random 		= 'hasil-' . time() . '-' . rand(100, 999);
				$export_name 	= __DIR__ . '/output/' . $random . '.jpg';
				$width       	= 600;
				$height      	= 800;
				$center_x    	= $width / 2;
				$center_x 		= 50;
				$center_y    	= 50;
				$max_len     	= 82;
				$font_size   	= 25;
				$font_height 	= 21;
				$lines 			= explode("\n", wordwrap($text, $max_len));
				$y     			= $center_y - ((count($lines) - 1) * $font_height);
				$y 				= ($y < $center_y) ? $y + ($center_y - ($y)) : $y;
				$count 			= (count($lines) > 35) ? 35 : count($lines);
				$img 			= Image::make($image_name);
				for ($i = 0; $i < $count; $i++) {
					$img->text($lines[$i], $center_x, $y, function ($font) {
						global $font_size;
						global $font_name;
						$font->file($font_name);
						$font->size($font_size);
						$font->color('#000000');
						$font->align('left');
					});
					$y += $font_height * 1;
				}
				$img->save($export_name);
				$nulis		= $random;
				$file 		= './output/' . $nulis . '.jpg';
				$img 		= curl_file_create($file, 'image/jpeg');
				$content 	= array('chat_id' => $chat_id, 'photo' => $img);
				$telegram->sendPhoto($content);
				unlink($file);
			} else if (strpos($text, '/tulis3') !== false) {
				$text 		= explode('/tulis3', $text)[1];
				$text		= trim($text);
				$reply 		= "Mohon ditunggu ya kak dan jangan spam yaa :)";
				$content 	= ['chat_id' => $chat_id, 'text' => $reply];
				$telegram->sendMessage($content);
				$image_name 	= __DIR__ . '/assets/img/folio.jpg';
				$font_name 		= __DIR__ . '/assets/font/my_handwriting/My_handwriting.ttf';
				$random 		= 'hasil-' . time() . '-' . rand(100, 999);
				$export_name 	= __DIR__ . '/output/' . $random . '.jpg';
				$width       	= 600;
				$height      	= 800;
				$center_x    	= $width / 2;
				$center_x 		= 55;
				$center_y    	= 96;
				$max_len     	= 78;
				$font_size   	= 25;
				$font_height 	= 19;
				$lines 			= explode("\n", wordwrap($text, $max_len));
				$y     			= $center_y - ((count($lines) - 1) * $font_height);
				$y 				= ($y < $center_y) ? $y + ($center_y - ($y)) : $y;
				$count 			= (count($lines) > 39) ? 39 : count($lines);
				$img 			= Image::make($image_name);
				for ($i = 0; $i < $count; $i++) {
					$img->text($lines[$i], $center_x, $y, function ($font) {
						global $font_size;
						global $font_name;
						$font->file($font_name);
						$font->size($font_size);
						$font->color('#000000');
						$font->align('left');
					});
					//echo $i.". ".$center_x.", ".$y." ".$font_height." => ".$lines[$i]."<br>";
					$font_height = ($i == 4) ? $font_height - 1 : $font_height;
					$font_height = ($i == 5) ? $font_height - 2 : $font_height;
					$font_height = ($i == 6) ? $font_height + 1 : $font_height;
					$y += $font_height * 1;
				}
				$img->save($export_name);
				$nulis 		= $random;
				$file 		= './output/' . $nulis . '.jpg';
				$img 		= curl_file_create($file, 'image/jpeg');
				$content 	= array('chat_id' => $chat_id, 'photo' => $img);
				$telegram->sendPhoto($content);
				unlink($file);
			} else if ($text == '/contact') {
				$option 	= array(array($telegram->buildInlineKeyBoardButton("Instagram", $url = "https://instagram.com/nthanfp"), $telegram->buildInlineKeyBoardButton("Twitter", $url = "https://twitter.com/Iostfrequencies")), array($telegram->buildInlineKeyBoardButton("Trakteer", $url = "https://trakteer.id/nthanfp")));
				$keyb 		= $telegram->buildInlineKeyBoard($option);
				$reply 		= "Hai kak! Jika ada error dalam fitur bot atau ingin memberi saran, bisa hubungi lewat sosial media di bawah ini yaa \xE2\xAC\x87 \n";
				$content 	= array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => $reply);
				$telegram->sendMessage($content);
			} else if ($text == '/testx') {
				if ($telegram->messageFromGroup()) {
					$reply = 'Chat Group';
				} else {
					$reply = 'Private Chat';
				}
				$option = [['A', 'B'], ['C', 'D']];
				$keyb = $telegram->buildKeyBoard($option);
				$content = ['chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => $reply];
				$telegram->sendMessage($content);
			} else if ($text == '/gitx') {
				$reply = 'Check me on GitHub: https://github.com/Eleirbag89/TelegramBotPHP';
				$content = ['chat_id' => $chat_id, 'text' => $reply];
				$telegram->sendMessage($content);
			}
			//sleep(1);
		}
	} else {
		echo "Error\n";
		var_dump($req);
	}
} while (true);

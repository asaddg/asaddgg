<?php
/*
✲ کانال زتو تی ام  ✲ به کانال ما برای دریافت سورس های بیشتر سر بزنید :) @Zeto_TM
*/
set_time_limit(0);
error_reporting(0);
ob_start();
//----------------------------
$token = "930462790:AAF1DSNLMUOuLFecqxaDoPxG0I1eklXNB78";
$sudo= 492527820;
//----------------------------------
define('API_KEY',"$token");
$infor=json_decode(file_get_contents("config.json"));
function bot($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}
$up=json_decode(file_get_contents('php://input'));
$bot_type_ads = file_get_contents('bot_type_ads.txt');
$caption=$up->message->caption;
$fwd_id=$up->message->reply_to_message->forward_from->id;
$first_name=$up->message->from->first_name;
$setting=json_decode(file_get_contents("setting.json"),true);
$json=json_decode(file_get_contents("dasturat.json"),true);
$last_name=$up->message->from->last_name;
$msg_id=$up->message->message_id;
$username=$up->message->from->username;
$chat_id=$up->message->chat->id;
$bottype = file_get_contents("bottype.txt");
$from_id=$up->message->from->id;
if(!file_exists("sudo.txt")){
  file_put_contents("sudo.txt","empty");
}
$vaziyat=file_get_contents("sudo.txt");
if(!file_exists("member.json")){
  file_put_contents("member.json",json_encode([$sudo]));
}
if(!file_exists("bakhsh.txt")){
  file_put_contents("bakhsh.txt","empty");
}
if(!file_exists("profile.txt")){
  file_put_contents("profile.txt","پروفایل خالی است.
  @eliyatm");
}
if(!file_exists("setting.json")){
  file_put_contents("setting.json",json_encode(["sticker"=>"no","video"=>"no","photo"=>"no","videoNote"=>"no","audio"=>"no","voice"=>"no","document"=>"no"]));
}
if(!file_exists("dasturat.json")){
  file_put_contents("dasturat.json",json_encode(["empty"=>"yes"]));
}
if(!file_exists("start.txt")){
  file_put_contents("start.txt","باسلام.خوش آمدید.\nلطفا پیام خود را ارسال نمایید.

");
}
if(!file_exists("block.txt")){
  file_put_contents("block.txt","block");
}
$text=$up->message->text;
$member=array_unique(json_decode(file_get_contents("member.json"),true));
if(isset($up->message)){
  if($from_id==$sudo){
    if($text=="لغو" and $vaziyat!="empty"){
       if($vaziyat=="pasokhzirdastur"){
        $commonds=$json[file_get_contents("bakhsh.txt")]["commonds"];
        
        foreach($json as $key=>$value){
          if(isset($json[$key]["commonds"])){
            if(array_search(file_get_contents("dastur.txt"),$commonds)!=false){
              unset($json[$key]["commonds"][array_search(file_get_contents("dastur.txt"),$commonds)+0]);
            }
          }
        }
        unset($json[file_get_contents("dastur.txt")]);
        $json=json_encode($json);
        file_put_contents("dasturat.json","$json");
        file_put_contents("sudo.txt","empty");
        file_put_contents("bakhsh.txt","empty");
        bot("sendMessage",[
          "chat_id"=>$chat_id,
          "text"=>"عملیات لغو شد."
        ]);
     }else{
      file_put_contents("sudo.txt","empty");
      bot("sendMessage",[
        "chat_id"=>$chat_id,
        "text"=>"_عملیات لغو شد._",
        "parse_mode"=>"markdown",
        "reply_markup"=>json_encode(["remove_keyboard"=>true])
      ]);
      }
    }elseif($vaziyat=="resetbot"){
      if($text=="بله"){
        unlink("start.txt");
        unlink("profile.txt");
        unlink("dasturat.json");
        unlink("setting.json");
        unlink("dastur.txt");
        unlink("bakhsh.txt");
        unlink("block.txt");
        file_put_contents("sudo.txt","empty");
        bot("sendMessage",[
          "chat_id"=>$chat_id,
          "text"=>"ربات با موفقیت ریست شد.",
          "reply_markup"=>json_encode(["remove_keyboard"=>true])
        ]);
      }else{
        bot("sendMessage",[
          "chat_id"=>$chat_id,
          "text"=>"لطفا یکی از گزینه های زیر را انتخاب کنید."
        ]);
      }
    }elseif($vaziyat=="hazfdastur"){
     
 $json=json_decode(file_get_contents("dasturat.json"),true);    
 if(isset($json[$text]) && $text!="empty"){
        unset($json[$text]);
        foreach($json as $key=>$value){
        if(isset($json[$key]["commonds"])){
   $commonds=$json[$key]["commonds"];
   unset($json[$key]["commonds"][array_search($text,$commonds)+0]);
 }}
        $json=json_encode($json);
        file_put_contents("dasturat.json","$json");
        file_put_contents("sudo.txt","empty");
        bot("sendMessage",[
        "chat_id"=>$chat_id,
        "text"=>"_دستور مورد نظر حذف شد._",
        "parse_mode"=>"markdown",
        "reply_markup"=>json_encode(["remove_keyboard"=>true])
      ]);
      }else{
        bot("sendMessage",[
        "chat_id"=>$chat_id,
        "text"=>"_این دستور موجود نیست._",
        "parse_mode"=>"markdown"
      ]);
      }
    }elseif($vaziyat=="forward"){
      foreach($member as $key=>$value){
        bot("forwardMessage",[
          "chat_id"=>$value,
          "from_chat_id"=>$chat_id,
          "message_id"=>$msg_id
        ]);
      }
      bot("sendMessage",[
        "chat_id"=>$chat_id,
        "text"=>"_پیام شما با موفقیت به تمام کاربران ارسال شد._",
        "parse_mode"=>"markdown",
        "reply_markup"=>json_encode(["remove_keyboard"=>true])
      ]);
      file_put_contents("sudo.txt","empty");
    }elseif($vaziyat=="forward2"){
      if(isset($up->message->text)){
        foreach($member as $key=>$value){
        bot("sendMessage",[
          "chat_id"=>$value,
          "text"=>$text
        ]);
      }
      bot("sendMessage",[
        "chat_id"=>$chat_id,
        "text"=>"_پیام شما با موفقیت به تمام کاربران ارسال شد._",
        "parse_mode"=>"markdown",
        "reply_markup"=>json_encode(["remove_keyboard"=>true])
      ]);
      file_put_contents("sudo.txt","empty");
      }elseif(isset($up->message->photo)){
        $up2=json_decode(file_get_contents("php://input"),true);
        $file_id=$up2["message"]["photo"][0]["file_id"];
        foreach($member as $key=>$value){
        bot("sendphoto",[
          "chat_id"=>$value,
          "photo"=>$file_id,
          "caption"=>$caption
        ]);
      }
      bot("sendMessage",[
        "chat_id"=>$chat_id,
        "text"=>"_پیام شما با موفقیت به تمام کاربران ارسال شد._",
        "parse_mode"=>"markdown",
        "reply_markup"=>json_encode(["remove_keyboard"=>true])
      ]);
      file_put_contents("sudo.txt","empty");
      }elseif(isset($up->message->audio)){
        $file_id=$up->message->audio->file_id;
        foreach($member as $key=>$value){
        bot("sendaudio",[
          "chat_id"=>$value,
          "caption"=>$caption,
          "audio"=>$file_id
        ]);
      }
      bot("sendMessage",[
        "chat_id"=>$chat_id,
        "text"=>"_پیام شما با موفقیت به تمام کاربران ارسال شد._",
        "parse_mode"=>"markdown",
        "reply_markup"=>json_encode(["remove_keyboard"=>true])
      ]);
      file_put_contents("sudo.txt","empty");
      }elseif(isset($up->message->document)){
        $file_id=$up->message->document->file_id;
        foreach($member as $key=>$value){
        bot("senddocument",[
          "chat_id"=>$value,
          "document"=>$file_id,
          "caption"=>$caption
        ]);
      }
      bot("sendMessage",[
        "chat_id"=>$chat_id,
        "text"=>"_پیام شما با موفقیت به تمام کاربران ارسال شد._",
        "parse_mode"=>"markdown",
        "reply_markup"=>json_encode(["remove_keyboard"=>true])
      ]);
      file_put_contents("sudo.txt","empty");
      }elseif(isset($up->message->video_note)){
        $file_id=$up->message->video_note->file_id;
        foreach($member as $key=>$value){
        bot("sendvideonote",[
          "chat_id"=>$value,
          "video_note"=>$file_id
        ]);
      }
      bot("sendMessage",[
        "chat_id"=>$chat_id,
        "text"=>"_پیام شما با موفقیت به تمام کاربران ارسال شد._",
        "parse_mode"=>"markdown",
        "reply_markup"=>json_encode(["remove_keyboard"=>true])
      ]);
      file_put_contents("sudo.txt","empty");
      }elseif(isset($up->message->video)){
        $file_id=$up->message->video->file_id;
        foreach($member as $key=>$value){
        bot("sendvideo",[
          "chat_id"=>$value,
          "video"=>$file_id,
          "caption"=>$caption
        ]);
      }
      bot("sendMessage",[
        "chat_id"=>$chat_id,
        "text"=>"_پیام شما با موفقیت به تمام کاربران ارسال شد._",
        "parse_mode"=>"markdown",
        "reply_markup"=>json_encode(["remove_keyboard"=>true])
      ]);
      file_put_contents("sudo.txt","empty");
      }elseif(isset($up->message->sticker)){
        $file_id=$up->message->sticker->file_id;
        foreach($member as $key=>$value){
        bot("sendsticker",[
          "chat_id"=>$value,
          "sticker"=>$file_id
        ]);
      }
      bot("sendMessage",[
        "chat_id"=>$chat_id,
        "text"=>"_پیام شما با موفقیت به تمام کاربران ارسال شد._",
        "parse_mode"=>"markdown",
        "reply_markup"=>json_encode(["remove_keyboard"=>true])
      ]); file_put_contents("sudo.txt","empty");
      }elseif(isset($up->message->voice)){
        $file_id=$up->message->voice->file_id;
        foreach($member as $key=>$value){
        bot("sendvoice",[
          "chat_id"=>$value,
          "voice"=>$file_id,
          "caption"=>$caption
        ]);
      }
      bot("sendMessage",[
        "chat_id"=>$chat_id,
        "text"=>"_پیام شما با موفقیت به تمام کاربران ارسال شد._",
        "parse_mode"=>"markdown",
        "reply_markup"=>json_encode(["remove_keyboard"=>true])
      ]);
      file_put_contents("sudo.txt","empty");
      }
    }elseif($vaziyat=="deletemenu"){
      if(isset($json[$text])){
        unset($json[$text]);
        foreach($json as $key=>$value){
          if(isset($json[$key]["commonds"])){
            $commonds=$json[$key]["commonds"];
            if(array_search($text,$commonds)!=false){
              unset($json[$key]["commonds"][array_search($text,$commonds)+0]);
              $json[$key]["commonds"]=array_values($json[$key]["commonds"]);
            }
          }
        }
       $json=json_encode($json);
       file_put_contents("dasturat.json","$json"); file_put_contents("sudo.txt","empty");
        bot("sendMessage",[
          "chat_id"=>$chat_id,
          "text"=>"منو یا زیر منو مورد نظر حذف شد.",
          "reply_markup"=>json_encode(["remove_keyboard"=>true])
        ]);
      }else{
        bot("sendMessage",[
          "chat_id"=>$chat_id,
          "text"=>"این منو یا زیر منو موجود نیست."
        ]);
      }
    }elseif($vaziyat=="createmenu"){
      if(isset($up->message->text)){
        if(isset($json[$text])){
          bot("sendMessage",[
          "chat_id"=>$chat_id,
          "text"=>"این دستور یا منو از قبل موجود است."
        ]);
        }else{
          $json[$text]["type"]="menu";
          $json[$text]["commonds"]=array("بازگشت به منوی اصلی");
          $json=json_encode($json);
          file_put_contents("sudo.txt","empty");
          file_put_contents("dasturat.json","$json");
          bot("sendMessage",[
            "chat_id"=>$chat_id,
            "text"=>"منو شما ایجاد شد و میتوانید در بخش مدیریت منو آن را مدیریت کنید.",
            "reply_markup"=>json_encode(["remove_keyboard"=>true])
          ]);
        }
      }else{
        bot("sendMessage",[
          "chat_id"=>$chat_id,
          "text"=>"لطفا متن بفرستید."
        ]);
      }
    }elseif($vaziyat=="profile"){
      if(isset($up->message->text)){
        bot("sendmessage",[
          "chat_id"=>$chat_id,
          "text"=>"_پیام پروفایل ذخیره شد._",
          "parse_mode"=>"markdown",
          "reply_markup"=>json_encode(["remove_keyboard"=>true])
        ]);
        file_put_contents("sudo.txt","empty");
        file_put_contents("profile.txt","$text");
      }else{
        bot("sendmessage",[
          "chat_id"=>$chat_id,
          "text"=>"_پیام فقط باید حاوی متن باشد._",
          "parse_mode"=>"markdown"
        ]);
      }
    }elseif($vaziyat=="dasturjadid"){
      $json=json_decode(file_get_contents("dasturat.json"),true);
      if(isset($up->message->text)){
        if(!isset($json[$text]) && $text!="empty" && $text!="/start" && $text!="پروفایل"){
          file_put_contents("dastur.txt","$text");
          file_put_contents("sudo.txt","pasokh");
          bot("sendMessage",[
          "chat_id"=>$chat_id,
          "text"=>"_حال پاسخ پیام خود را ارسال کنید._",
          "parse_mode"=>"markdown"
        ]);
        }else{
          bot("sendMessage",[
          "chat_id"=>$chat_id,
          "text"=>"_این دستور از قبل موجود است._",
          "parse_mode"=>"markdown"
        ]);
        }
      }else{
        bot("sendMessage",[
          "chat_id"=>$chat_id,
          "text"=>"_دستور فقط باید متن باشد._",
          "parse_mode"=>"markdown"
        ]);
      }
    }elseif($vaziyat=="pasokh" or $vaziyat=="pasokhzirdastur"){
      if(isset($up->message->text)){
   $json=json_decode(file_get_contents("dasturat.json"),true);
          $json[file_get_contents("dastur.txt")]["text"]="$text";
          $json=json_encode($json);
          file_put_contents("dasturat.json","$json");
         file_put_contents("sudo.txt","empty");
            bot("sendmessage",[
          "chat_id"=>$chat_id,
          "text"=>"_دستور شما ذخیره شد._",
          "parse_mode"=>"markdown",
          "reply_markup"=>json_encode(["remove_keyboard"=>true])
        ]);
      }elseif(isset($up->message->photo)){
        $json=json_decode(file_get_contents("dasturat.json"),true);
        $up2=json_decode(file_get_contents("php://input"),true);
        $json[file_get_contents("dastur.txt")]["file_id"]=$up2["message"]["photo"][0]["file_id"];
        $json[file_get_contents("dastur.txt")]["caption"]="$caption";
        $json[file_get_contents("dastur.txt")]["type"]="photo";
        $json=json_encode($json);
        file_put_contents("dasturat.json","$json");
         file_put_contents("sudo.txt","empty");

            bot("sendmessage",[
          "chat_id"=>$chat_id,
          "text"=>"_دستور شما ذخیره شد._",
          "parse_mode"=>"markdown",
          "reply_markup"=>json_encode(["remove_keyboard"=>true])
        ]);
      }elseif(isset($up->message->video)){
        $json=json_decode(file_get_contents("dasturat.json"),true);
        $json[file_get_contents("dastur.txt")]["caption"]="$caption";
        $json[file_get_contents("dastur.txt")]["file_id"]=$up->message->video->file_id;
        $json[file_get_contents("dastur.txt")]["type"]="video";
        $json=json_encode($json);
        file_put_contents("dasturat.json","$json");
         file_put_contents("sudo.txt","empty");

            bot("sendmessage",[
          "chat_id"=>$chat_id,
          "text"=>"_دستور شما ذخیره شد._",
          "parse_mode"=>"markdown",
          "reply_markup"=>json_encode(["remove_keyboard"=>true])
        ]);
      }elseif(isset($up->message->video_note)){
        $json=json_decode(file_get_contents("dasturat.json"),true);
        $json[file_get_contents("dastur.txt")]["file_id"]=$up->message->video_note->file_id;
        $json[file_get_contents("dastur.txt")]["type"]="video_note";
        $json=json_encode($json);
        file_put_contents("dasturat.json","$json");
         file_put_contents("sudo.txt","empty");
            bot("sendmessage",[
          "chat_id"=>$chat_id,
          "text"=>"_دستور شما ذخیره شد._",
          "parse_mode"=>"markdown",
          "reply_markup"=>json_encode(["remove_keyboard"=>true])
        ]);
      }elseif(isset($up->message->sticker)){
        $json=json_decode(file_get_contents("dasturat.json"),true);
        $json[file_get_contents("dastur.txt")]["file_id"]=$up->message->sticker->file_id;
        $json[file_get_contents("dastur.txt")]["type"]="sticker";
        $json=json_encode($json);
        file_put_contents("dasturat.json","$json");
         file_put_contents("sudo.txt","empty");
            bot("sendmessage",[
          "chat_id"=>$chat_id,
          "text"=>"_دستور شما ذخیره شد._",
          "parse_mode"=>"markdown",
          "reply_markup"=>json_encode(["remove_keyboard"=>true])
        ]);
      }elseif(isset($up->message->voice)){
        $json=json_decode(file_get_contents("dasturat.json"),true);
        $json[file_get_contents("dastur.txt")]["caption"]="$caption";
        $json[file_get_contents("dastur.txt")]["file_id"]=$up->message->voice->file_id;
        $json[file_get_contents("dastur.txt")]["type"]="voice";
        $json=json_encode($json);
        file_put_contents("dasturat.json","$json");
         file_put_contents("sudo.txt","empty");
            bot("sendmessage",[
          "chat_id"=>$chat_id,
          "text"=>"_دستور شما ذخیره شد._",
          "parse_mode"=>"markdown",
          "reply_markup"=>json_encode(["remove_keyboard"=>true])
        ]);
      }elseif(isset($up->message->audio)){
        $json=json_decode(file_get_contents("dasturat.json"),true);
        $json[file_get_contents("dastur.txt")]["caption"]="$caption";
        $json[file_get_contents("dastur.txt")]["file_id"]=$up->message->audio->file_id;
        $json[file_get_contents("dastur.txt")]["type"]="audio";
        $json=json_encode($json);
        file_put_contents("dasturat.json","$json");
         file_put_contents("sudo.txt","empty");
            bot("sendmessage",[
          "chat_id"=>$chat_id,
          "text"=>"_دستور شما ذخیره شد._",
          "parse_mode"=>"markdown",
          "reply_markup"=>json_encode(["remove_keyboard"=>true])
        ]);
      }elseif(isset($up->message->document)){
        $json=json_decode(file_get_contents("dasturat.json"),true);
        $json[file_get_contents("dastur.txt")]["caption"]="$caption";
        $json[file_get_contents("dastur.txt")]["file_id"]=$up->message->document->file_id;
        $json[file_get_contents("dastur.txt")]["type"]="document";
        $json=json_encode($json);
        file_put_contents("dasturat.json","$json");
         file_put_contents("sudo.txt","empty");
            bot("sendmessage",[
          "chat_id"=>$chat_id,
          "text"=>"_دستور شما ذخیره شد._",
          "parse_mode"=>"markdown",
          "reply_markup"=>json_encode(["remove_keyboard"=>true])
        ]);
      }
    }elseif($vaziyat=="zirmenu"){
      if(isset($up->message->text)){
        if(isset($json[$text])){
          bot("sendmessage",[
          "chat_id"=>$chat_id,
          "text"=>"این دستور یا منو از قبل موجود است."
        ]);
        }else{
          $json[$text]["type"]="menu";
          $json[$text]["type2"]="zirmenu";
          $json[$text]["commonds"]=array("بازگشت به منوی اصلی");
          $commonds=$json[file_get_contents("bakhsh.txt")]["commonds"];
          unset($commonds[array_search("بازگشت به منوی اصلی",$commonds)+0]);
          $json[file_get_contents("bakhsh.txt")]["commonds"][count($commonds)]=$text;
          $commonds=$json[file_get_contents("bakhsh.txt")]["commonds"];
          $json[file_get_contents("bakhsh.txt")]["commonds"][count($commonds)]="بازگشت به منوی اصلی";
          $json=json_encode($json);
          file_put_contents("bakhsh.txt","empty");
          file_put_contents("sudo.txt","empty");
          file_put_contents("dasturat.json","$json");
          bot("sendmessage",[
          "chat_id"=>$chat_id,
          "text"=>"منو شما ایجاد شد.",
          "reply_markup"=>json_encode(["remove_keyboard"=>true])
        ]);
        }
      }else{
        bot("sendmessage",[
          "chat_id"=>$chat_id,
          "text"=>"لطفا متن بفرستید."
        ]);
      }
    }elseif($vaziyat=="zirdastur"){
      if(isset($up->message->text)){
        if(isset($json[$text])){
          bot("sendmessage",[
          "chat_id"=>$chat_id,
          "text"=>"این دستور یا منو از قبل موجود است."
        ]);
        }else{
          $json[$text]["type2"]="zirdastur";
          $commonds=$json[file_get_contents("bakhsh.txt")]["commonds"];
          unset($commonds[array_search("بازگشت به منوی اصلی",$commonds)+0]);
          $json[file_get_contents("bakhsh.txt")]["commonds"][count($commonds)]=$text;
          $commonds=$json[file_get_contents("bakhsh.txt")]["commonds"];
          $json[file_get_contents("bakhsh.txt")]["commonds"][count($commonds)]="بازگشت به منوی اصلی";
          $json=json_encode($json);
          file_put_contents("bakhsh.txt","empty");
          file_put_contents("sudo.txt","pasokhzirdastur");
          file_put_contents("dastur.txt",$text);
          file_put_contents("dasturat.json","$json");
          bot("sendMessage",[
            "chat_id"=>$chat_id,
            "text"=>"حالا پاسخ دستور خود را بفرستید."
          ]);
        }
      }else{
        bot("sendmessage",[
          "chat_id"=>$chat_id,
          "text"=>"لطفا متن بفرستید."
        ]);
      }
    }elseif($vaziyat=="start"){
      if(isset($up->message->text)){
        bot("sendmessage",[
          "chat_id"=>$chat_id,
          "text"=>"_پیام دستور استارت تغییر کرد._",
          "parse_mode"=>"markdown",
          "reply_markup"=>json_encode(["remove_keyboard"=>true])
        ]);
        file_put_contents("sudo.txt","empty");
        file_put_contents("start.txt","$text");
      }else{
        bot("sendmessage",[
          "chat_id"=>$chat_id,
          "text"=>"_پیام فقط باید حاوی متن باشد._",
          "parse_mode"=>"markdown"
        ]);
      }
    }elseif($text=="/block" and isset($up->message->reply_to_message->forward_from->id) and $fwd_id!=$sudo){
      $file=fopen("block.txt","a");
      fwrite($file,"\n$fwd_id");
      fclose($file);
      bot("sendmessage",[
          "chat_id"=>$fwd_id,
          "text"=>"_کاربر شما از ربات بلاک شدید._",
          "parse_mode"=>"markdown"
        ]);
        bot("sendmessage",[
          "chat_id"=>$chat_id,
          "text"=>"_کاربر $fwd_id بلاک شد._",
          "parse_mode"=>"markdown"
        ]); 
    }elseif(isset($up->message->reply_to_message) && !empty($fwd_id)){
      if(isset($up->message->text)){
        bot("sendMessage",[
          "chat_id"=>$fwd_id,
          "text"=>$text
        ]);
      }elseif(isset($up->message->photo)){
        $up2=json_decode(file_get_contents("php://input"),true);
        $file_id=$up2["message"]["photo"][0]["file_id"];
        bot("sendphoto",[
          "chat_id"=>$fwd_id,
          "caption"=>$caption,
          "photo"=>$file_id
        ]);
      }elseif(isset($up->message->video)){
        $file_id=$up->message->video->file_id;
        bot("sendvideo",[
          "chat_id"=>$fwd_id,
          "caption"=>$caption,
          "video"=>$file_id
        ]);
      }elseif(isset($up->message->video_note)){
        $file_id=$up->message->video_note->file_id;
        bot("sendvideonote",[
          "chat_id"=>$fwd_id,
          "video_note"=>$file_id
        ]);
      }elseif(isset($up->message->sticker)){
        $file_id=$up->message->sticker->file_id;
        bot("sendsticker",[
          "chat_id"=>$fwd_id,
          "sticker"=>$file_id
        ]);
      }elseif(isset($up->message->voice)){
        $file_id=$up->message->voice->file_id;
        bot("sendVoice",[
          "chat_id"=>$fwd_id,
          "caption"=>$caption,
          "voice"=>$file_id
        ]);
      }elseif(isset($up->message->audio)){
        $file_id=$up->message->audio->file_id;
        bot("sendAudio",[
          "chat_id"=>$fwd_id,
          "caption"=>$caption,
          "audio"=>$file_id
        ]);
      }elseif(isset($up->message->document)){
        $file_id=$up->message->document->file_id;
        bot("sendDocument",[
          "chat_id"=>$fwd_id,
          "caption"=>$caption,
          "document"=>$file_id
        ]);
      }
        bot("sendmessage",[
          "chat_id"=>$chat_id,
          "text"=>"_پیام شما باموفقیت ارسال شد._",
          "parse_mode"=>"markdown"
        ]);
    }elseif($text=="ایجاد منو" && file_get_contents("bakhsh.txt")!="empty"){
      file_put_contents("sudo.txt","zirmenu");
      bot("sendMessage",[
        "chat_id"=>$chat_id,
        "text"=>"نام منو را ارسال کنید.",
        "reply_markup"=>json_encode(["resize_keyboard"=>true,"keyboard"=>[[["text"=>"لغو"]]]])
      ]);
    }elseif($text=="ایجاد دستور" && file_get_contents("bakhsh.txt")!="empty"){
      file_put_contents("sudo.txt","zirdastur");
      bot("sendMessage",[
        "chat_id"=>$chat_id,
        "text"=>"دستور خود را ارسال کنید.",
        "reply_markup"=>json_encode(["resize_keyboard"=>true,"keyboard"=>[[["text"=>"لغو"]]]])
      ]);
    }elseif(isset($json[$text]["commonds"])){
      file_put_contents("bakhsh.txt",$text);
      bot("sendMessage",[
        "chat_id"=>$chat_id,
        "text"=>"یکی از گزینه های زیر را انتخاب کنید.",
        "reply_markup"=>json_encode(["resize_keyboard"=>true,"keyboard"=>[[["text"=>"ایجاد منو"],["text"=>"ایجاد دستور"]],[["text"=>"بازگشت به منوی اصلی"]]]])
      ]);
    }elseif($text=="بازگشت به منوی اصلی"){
      bot("sendmessage",[
          "chat_id"=>$chat_id,
          "text"=>"_به بخش اصلی برگشتیم میتونی دوباره دستور /start رو ارسال کنی._",
          "parse_mode"=>"markdown",
          "reply_markup"=>json_encode(["remove_keyboard"=>true])]);
    }elseif($text=="/memberfile"){
      bot("sendDocument",[
        "chat_id"=>$chat_id,
        "document"=>new CurlFile("member.txt")
      ]);
    }elseif($text=="/turn off"){
      if(!is_file("lock")){
        file_put_contents("lock","");
        bot("sendMessage",[
          "chat_id"=>$chat_id,
          "text"=>"ربات برای کاربران خاموش گردید."
        ]);
      }else{
        bot("sendMessage",[
          "chat_id"=>$chat_id,
          "text"=>"ربات از پیش برای کاربران خاموش است."
        ]);
      }
    }elseif($text=="/turn on"){
      if(is_file("lock")){
        unlink("lock");
        bot("sendMessage",[
          "chat_id"=>$chat_id,
          "text"=>"ربات برای کاربران دوباره روشن شد."
        ]);
      }else{
        bot("sendMessage",[
          "chat_id"=>$chat_id,
          "text"=>"ربات از پیش برای کاربران روشن است."
        ]);
      }
    }
    elseif($text=="/creator"){
        bot("sendMessage",[
          "chat_id"=>$chat_id,
          "text"=>"🤖ساخته شده توسط ایلیاتیم:
		  @EliyaTM",
  
        ]);
		 }
    elseif($text=="/start"){
    file_put_contents("bakhsh.txt","empty");
      bot("sendmessage",[
          "chat_id"=>$chat_id,
          "text"=>"_چکاری میتونم انجام بدم ادمین؟_",
          "parse_mode"=>"markdown",
          "reply_markup"=>json_encode(["remove_keyboard"=>true,"inline_keyboard"=>[[["text"=>"آمار 👥","callback_data"=>"amar"],["text"=>"پروفایل 👤","callback_data"=>"profile"]],[["text"=>"فروارد همگانی 🗣","callback_data"=>"forward"],["text"=>"بلاک لیست 🚫","callback_data"=>"block"]],[["text"=>"♨️ پیام استارت ربات ♨️","callback_data"=>"start"]],[["text"=>"✏️فروارد بدون عنوان✏️","callback_data"=>"forward2"]],[["text"=>"دستور ➕","callback_data"=>"dasturjadid"],["text"=>"دستور ➖","callback_data"=>"hazfdastur"]],[["text"=>"منو ➕","callback_data"=>"createmenu"],["text"=>"منو ➖","callback_data"=>"deletemenu"]],[["text"=>"⚜ مدیریت منو ⚜","callback_data"=>"managementmenu"]],[["text"=>"® ریست ربات ®","callback_data"=>"resetbot"]],[["text"=>"✉️ تنظیمات قفل پیام ها ✉️","callback_data"=>"settingmsg"]]]])
        ]);
    }
  }else{
   if(!strstr(file_get_contents("block.txt"),"$from_id")){
   if(!is_file("lock")){
    if(!isset($up->message->forward_from) && !isset($up->message->forward_from_chat)){
    $json=json_decode(file_get_contents("dasturat.json"),true);
      if($text=="لغو" && is_file("$from_id.txt")){
      unlink("$from_id.txt");
      bot("sendMessage",[
        "chat_id"=>$chat_id,
        "text"=>"عملیات لغو شد.",
        "reply_markup"=>json_encode(["remove_keyboard"=>true])
      ]);
    }elseif(is_file("$from_id.txt")){
      if(isset($up->message->contact)){
        $user_id=$up->message->contact->user_id;
        if($user_id==$from_id){
          bot("forwardMessage",[
            "chat_id"=>$sudo,
            "from_chat_id"=>$chat_id,
            "message_id"=>$msg_id
          ]);
          bot("sendMessage",[
            "text"=>"منتظر پاسخ ادمین باشید.",
            "chat_id"=>$chat_id,
            "reply_markup"=>json_encode(["remove_keyboard"=>true])
          ]);
          unlink("$from_id.txt");
        }else{
          bot("sendMessage",[
            "text"=>"این تایید هویت مربوط به شما نیست لطفا هویت خود را تایید کنید.",
            "chat_id"=>$chat_id
          ]);
        }
      }else{
        bot("sendMessage",[
            "text"=>"لطفا هویت خود را تایید نمایید.",
            "chat_id"=>$chat_id
          ]);
      }
    }elseif($text=="/start" or $text=="بازگشت به منوی اصلی"){
        $start=str_replace("userid","$from_id",file_get_contents("start.txt"));
        $start=str_replace("username","$username",$start);
        $start=str_replace("firstname","$first_name",$start);
        $start=str_replace("lastname","$last_name",$start);
        $list=array();
        $list[0]=array(array("text"=>"پروفایل"));
        $arrayjs=json_decode(file_get_contents("dasturat.json"),true);
        unset($arrayjs["empty"]);
        $n=0;
        foreach($arrayjs as $key=>$value){
        if($arrayjs[$key]["type2"]!="zirdastur" and $arrayjs[$key]["type2"]!="zirmenu"){
          $n++;
          $list[$n]=array(array("text"=>"$key"));}
        }
		
        bot("sendMessage",[
          "chat_id"=>$chat_id,
          "text"=>"$start",
          "reply_markup"=>json_encode(["resize_keyboard"=>true,"keyboard"=>$list])
        ]);
		 }
        if(array_search($from_id,$member)===false){
          array_push($member,$from_id);
          $json=json_encode($member);
          file_put_contents("member.json","$json");
        }
      }elseif($text=="/taidhoviyat"){
      bot("sendMessage",[
        "chat_id"=>$chat_id,
        "text"=>"لطفا برای تایید هویت روی گزینه تایید هویت کلیک کنید.",
        "reply_markup"=>json_encode(["resize_keyboard"=>true,"keyboard"=>[[["text"=>"تایید هویت","request_contact"=>true]],[["text"=>"لغو"]]]])
      ]);
      file_put_contents("$from_id.txt","empty");
    }elseif($text=="پروفایل"){
        $profile=file_get_contents("profile.txt");
        bot("sendMessage",[
          "chat_id"=>$chat_id,
          "text"=>"$profile"
        ]);
      }elseif(isset($json[$text]) && $text!="empty"){
        if(isset($json[$text]["text"])){
          bot("sendMessage",[
            "chat_id"=>$chat_id,
            "text"=>$json[$text]["text"],
            "parse_mode"=>"html"
          ]);
        }elseif($json[$text]["type"]=="menu"){
          $array=$json[$text]["commonds"];
          $list=array();
          foreach($array as $key=>$value){
            $list[$key]=array(array("text"=>"$value"));
          }
          bot("sendMessage",[
            "chat_id"=>$chat_id,
            "text"=>"لطفا یکی از گزینه های زیر را انتخاب کنید.",
            "reply_markup"=>json_encode(["resize_keyboard"=>true,"keyboard"=>$list])
          ]);
        }elseif($json[$text]["type"]=="sticker"){
          bot("sendSticker",[
            "chat_id"=>$chat_id,
            "sticker"=>$json[$text]["file_id"]
          ]);
        }elseif($json[$text]["type"]=="video"){
          bot("sendVideo",[
            "chat_id"=>$chat_id,
            "video"=>$json[$text]["file_id"],
            "caption"=>$json[$text]["caption"]
          ]);
        }elseif($json[$text]["type"]=="video_note"){
          bot("sendVideoNote",[
            "chat_id"=>$chat_id,
            "video_note"=>$json[$text]["file_id"]
          ]);
        }elseif($json[$text]["type"]=="photo"){
          bot("sendPhoto",[
            "chat_id"=>$chat_id,
            "photo"=>$json[$text]["file_id"],
            "caption"=>$json[$text]["caption"]
          ]);
        }elseif($json[$text]["type"]=="audio"){
          bot("sendAudio",[
            "chat_id"=>$chat_id,
            "audio"=>$json[$text]["file_id"],
            "caption"=>$json[$text]["caption"]
          ]);
        }elseif($json[$text]["type"]=="voice"){
          bot("sendVoice",[
            "chat_id"=>$chat_id,
            "voice"=>$json[$text]["file_id"],
            "caption"=>$json[$text]["caption"]
          ]);
        }elseif($json[$text]["type"]=="document"){
          bot("sendDocument",[
            "chat_id"=>$chat_id,
            "document"=>$json[$text]["file_id"],
            "caption"=>$json[$text]["caption"]
          ]);
        }
      }else{
       if(isset($up->message->text)){
        bot("forwardMessage",[
          "chat_id"=>$sudo,
          "from_chat_id"=>$chat_id,
          "message_id"=>$msg_id
        ]);
        bot("sendMessage",[
          "chat_id"=>$chat_id,
          "text"=>"_پیام شما با موفقیت ارسال شد._",
          "parse_mode"=>"markdown"
        ]);
        }elseif(isset($up->message->photo)){
          if($setting["photo"]=="no"){
            bot("forwardMessage",[
          "chat_id"=>$sudo,
          "from_chat_id"=>$chat_id,
          "message_id"=>$msg_id
        ]);
        bot("sendMessage",[
          "chat_id"=>$chat_id,
          "text"=>"_پیام شما با موفقیت ارسال شد._",
          "parse_mode"=>"markdown"
        ]);
          }else{
            bot("sendMessage",[
          "chat_id"=>$chat_id,
          "text"=>"_این نوع پیام توسط ادمین قفل شده است.لطفا پیام دیگری ارسال کنید._",
          "parse_mode"=>"markdown"
        ]);
          }
        }elseif(isset($up->message->sticker)){
          if($setting["sticker"]=="no"){
            bot("forwardMessage",[
          "chat_id"=>$sudo,
          "from_chat_id"=>$chat_id,
          "message_id"=>$msg_id
        ]);
        bot("sendMessage",[
          "chat_id"=>$chat_id,
          "text"=>"_پیام شما با موفقیت ارسال شد._",
          "parse_mode"=>"markdown"
        ]);
          }else{
            bot("sendMessage",[
          "chat_id"=>$chat_id,
          "text"=>"_این نوع پیام توسط ادمین قفل شده است.لطفا پیام دیگری ارسال کنید._",
          "parse_mode"=>"markdown"
        ]);
          }
        }elseif(isset($up->message->video)){
          if($setting["video"]=="no"){
            bot("forwardMessage",[
          "chat_id"=>$sudo,
          "from_chat_id"=>$chat_id,
          "message_id"=>$msg_id
        ]);
        bot("sendMessage",[
          "chat_id"=>$chat_id,
          "text"=>"_پیام شما با موفقیت ارسال شد._",
          "parse_mode"=>"markdown"
        ]);
          }else{
            bot("sendMessage",[
          "chat_id"=>$chat_id,
          "text"=>"_این نوع پیام توسط ادمین قفل شده است.لطفا پیام دیگری ارسال کنید._",
          "parse_mode"=>"markdown"
        ]);
          }
        }elseif(isset($up->message->video_note)){
          if($setting["videoNote"]=="no"){
            bot("forwardMessage",[
          "chat_id"=>$sudo,
          "from_chat_id"=>$chat_id,
          "message_id"=>$msg_id
        ]);
        bot("sendMessage",[
          "chat_id"=>$chat_id,
          "text"=>"_پیام شما با موفقیت ارسال شد._",
          "parse_mode"=>"markdown"
        ]);
          }else{
            bot("sendMessage",[
          "chat_id"=>$chat_id,
          "text"=>"_این نوع پیام توسط ادمین قفل شده است.لطفا پیام دیگری ارسال کنید._",
          "parse_mode"=>"markdown"
        ]);
          }
        }elseif(isset($up->message->audio)){
          if($setting["audio"]=="no"){
            bot("forwardMessage",[
          "chat_id"=>$sudo,
          "from_chat_id"=>$chat_id,
          "message_id"=>$msg_id
        ]);
        bot("sendMessage",[
          "chat_id"=>$chat_id,
          "text"=>"_پیام شما با موفقیت ارسال شد._",
          "parse_mode"=>"markdown"
        ]);
          }else{
            bot("sendMessage",[
          "chat_id"=>$chat_id,
          "text"=>"_این نوع پیام توسط ادمین قفل شده است.لطفا پیام دیگری ارسال کنید._",
          "parse_mode"=>"markdown"
        ]);
          }
        }elseif(isset($up->message->voice)){
          if($setting["voice"]=="no"){
            bot("forwardMessage",[
          "chat_id"=>$sudo,
          "from_chat_id"=>$chat_id,
          "message_id"=>$msg_id
        ]);
        bot("sendMessage",[
          "chat_id"=>$chat_id,
          "text"=>"_پیام شما با موفقیت ارسال شد._",
          "parse_mode"=>"markdown"
        ]);
          }else{
            bot("sendMessage",[
          "chat_id"=>$chat_id,
          "text"=>"_این نوع پیام توسط ادمین قفل شده است.لطفا پیام دیگری ارسال کنید._",
          "parse_mode"=>"markdown"
        ]);
          }
        }elseif(isset($up->message->document)){
          if($setting["document"]=="no"){
            bot("forwardMessage",[
          "chat_id"=>$sudo,
          "from_chat_id"=>$chat_id,
          "message_id"=>$msg_id
        ]);
        bot("sendMessage",[
          "chat_id"=>$chat_id,
          "text"=>"_پیام شما با موفقیت ارسال شد._",
          "parse_mode"=>"markdown"
        ]);
          }else{
            bot("sendMessage",[
          "chat_id"=>$chat_id,
          "text"=>"_این نوع پیام توسط ادمین قفل شده است.لطفا پیام دیگری ارسال کنید._",
          "parse_mode"=>"markdown"
        ]);
          }
        }
      }
    }else{
      bot("sendMessage",[
          "chat_id"=>$chat_id,
          "text"=>"_لطفا از جایی پیام فروارد نکنید._",
          "parse_mode"=>"markdown"
        ]);
    }}else{
   bot("sendMessage",[
          "chat_id"=>$chat_id,
          "text"=>"ربات توسط ادمین خاموش شده است و به هیچ پیامی پاسخ داده نمی شود."
        ]);
 }}
  }
elseif(isset($up->callback_query)){
$data=$up->callback_query->data;
$cl_msgid=$up->callback_query->message->message_id;
$cl_fromid=$up->callback_query->from->id;
$cl_chatid=$up->callback_query->message->chat->id;
  if($cl_fromid==$sudo){
    if($vaziyat=="empty"){
      if($data=="amar"){
        $count=count($member);
        bot("editMessageText",[
          "chat_id"=>$cl_chatid,
          "text"=>"_آمار ربات با احتساب خودتان $count نفر است._",
          "message_id"=>$cl_msgid,
          "parse_mode"=>"markdown",
          "reply_markup"=>json_encode(["inline_keyboard"=>[[["text"=>"بازگشت 🔙","callback_data"=>"back"]]]])
        ]);
      }elseif($data=="resetbot"){
        file_put_contents("sudo.txt","resetbot");
        bot("sendMessage",[
            "chat_id"=>$cl_chatid,
            "text"=>"آیا مطمئن هستید ؟",
            "reply_markup"=>json_encode(["resize_keyboard"=>true,"keyboard"=>[[["text"=>"لغو"],["text"=>"بله"]]]])
          ]);
      }elseif($data=="hazfdastur"){
       $json=json_decode(file_get_contents("dasturat.json"),true); 
       if(count($json)!=1){
         unset($json["empty"]);
         foreach($json as $key=>$value){
          if($json[$key]["type"]!="menu"){
           $list="$list\n$key";
         }} file_put_contents("sudo.txt","hazfdastur");
          bot("sendMessage",[
            "chat_id"=>$cl_chatid,
            "text"=>"دستور مورد نظر را برای حذف بفرستید.\nدستورات شما:\n".$list,
            "reply_markup"=>json_encode(["resize_keyboard"=>true,"keyboard"=>[[["text"=>"لغو"]]]])
          ]);
        }else{
          bot("sendMessage",[
            "chat_id"=>$cl_chatid,
            "text"=>"_دستوری موجود نیست._",
            "parse_mode"=>"markdown"
          ]);
        }
      }elseif($data=="back"){
        bot("editMessageText",[
          "chat_id"=>$cl_chatid,
          "text"=>"_چکاری میتونم انجام بدم ادمین؟_",
          "message_id"=>$cl_msgid,
          "parse_mode"=>"markdown",
          "reply_markup"=>json_encode(["inline_keyboard"=>[[["text"=>"آمار 👥","callback_data"=>"amar"],["text"=>"پروفایل 👤","callback_data"=>"profile"]],[["text"=>"فروارد همگانی 🗣","callback_data"=>"forward"],["text"=>"بلاک لیست 🚫","callback_data"=>"block"]],[["text"=>"♨️ پیام استارت ربات ♨️","callback_data"=>"start"]],[["text"=>"✏️فروارد بدون عنوان✏️","callback_data"=>"forward2"]],[["text"=>"دستور ➕","callback_data"=>"dasturjadid"],["text"=>"دستور ➖","callback_data"=>"hazfdastur"]],[["text"=>"منو ➕","callback_data"=>"createmenu"],["text"=>"منو ➖","callback_data"=>"deletemenu"]],[["text"=>"⚜ مدیریت منو ⚜","callback_data"=>"managementmenu"]],[["text"=>"® ریست ربات ®","callback_data"=>"resetbot"]],[["text"=>"✉️ تنظیمات قفل پیام ها ✉️","callback_data"=>"settingmsg"]]]])
        ]);
      }elseif($data=="settingmsg"){
        $list=array();
        $num=0;
        foreach($setting as $key=>$value){
          $list[$num]=array(array("text"=>"$key","callback_data"=>"$key"),array("text"=>"$value","callback_data"=>"$key:$value"));
          $num++;
        }
        bot("sendMessage",[
          "chat_id"=>$cl_chatid,
          "text"=>"_>>>تنظیمات قفل پیام ها<<<_",
          "parse_mode"=>"markdown",
          "reply_markup"=>json_encode(["inline_keyboard"=>$list])
        ]);
      }elseif($data=="sticker:yes"){
        $setting["sticker"]="no";
        $option=json_encode($setting);
        file_put_contents("setting.json","$option");
        $num=0;
        $list=array();
        foreach($setting as $key=>$value){
          $list[$num]=array(array("text"=>"$key","callback_data"=>"$key"),array("text"=>"$value","callback_data"=>"$key:$value"));
          $num++;
        }
        bot("editMessageReplyMarkup",[
        "chat_id"=>$cl_chatid,
        "message_id"=>$cl_msgid,
        "reply_markup"=>json_encode(["inline_keyboard"=>$list])
        ]);
        bot("answerCallbackQuery",[
          "callback_query_id"=>$up->callback_query->id,
          "text"=>"انجام شد."
        ]);
      }elseif($data=="sticker:no"){
        $setting["sticker"]="yes";
        $option=json_encode($setting);
        file_put_contents("setting.json","$option");
        $num=0;
        $list=array();
        foreach($setting as $key=>$value){
          $list[$num]=array(array("text"=>"$key","callback_data"=>"$key"),array("text"=>"$value","callback_data"=>"$key:$value"));
          $num++;
        }
        bot("editMessageReplyMarkup",[
        "chat_id"=>$cl_chatid,
        "message_id"=>$cl_msgid,
        "reply_markup"=>json_encode(["inline_keyboard"=>$list])
        ]);
        bot("answerCallbackQuery",[
          "callback_query_id"=>$up->callback_query->id,
          "text"=>"انجام شد."
        ]);
      }elseif($data=="photo:yes"){
        $setting["photo"]="no";
        $option=json_encode($setting);
        file_put_contents("setting.json","$option");
        $num=0;
        $list=array();
        foreach($setting as $key=>$value){
          $list[$num]=array(array("text"=>"$key","callback_data"=>"$key"),array("text"=>"$value","callback_data"=>"$key:$value"));
          $num++;
        }
        bot("editMessageReplyMarkup",[
        "chat_id"=>$cl_chatid,
        "message_id"=>$cl_msgid,
        "reply_markup"=>json_encode(["inline_keyboard"=>$list])
        ]);
        bot("answerCallbackQuery",[
          "callback_query_id"=>$up->callback_query->id,
          "text"=>"انجام شد."
        ]);
      }elseif($data=="photo:no"){
        $setting["photo"]="yes";
        $option=json_encode($setting);
        file_put_contents("setting.json","$option");
        $num=0;
        $list=array();
        foreach($setting as $key=>$value){
          $list[$num]=array(array("text"=>"$key","callback_data"=>"$key"),array("text"=>"$value","callback_data"=>"$key:$value"));
          $num++;
        }
        bot("editMessageReplyMarkup",[
        "chat_id"=>$cl_chatid,
        "message_id"=>$cl_msgid,
        "reply_markup"=>json_encode(["inline_keyboard"=>$list])
        ]);
        bot("answerCallbackQuery",[
          "callback_query_id"=>$up->callback_query->id,
          "text"=>"انجام شد."
        ]);
      }elseif($data=="video:yes"){
        $setting["video"]="no";
        $option=json_encode($setting);
        file_put_contents("setting.json","$option");
        $num=0;
        $list=array();
        foreach($setting as $key=>$value){
          $list[$num]=array(array("text"=>"$key","callback_data"=>"$key"),array("text"=>"$value","callback_data"=>"$key:$value"));
          $num++;
        }
        bot("editMessageReplyMarkup",[
        "chat_id"=>$cl_chatid,
        "message_id"=>$cl_msgid,
        "reply_markup"=>json_encode(["inline_keyboard"=>$list])
        ]);
        bot("answerCallbackQuery",[
          "callback_query_id"=>$up->callback_query->id,
          "text"=>"انجام شد."
        ]);
      }elseif($data=="video:no"){
        $setting["video"]="yes";
        $option=json_encode($setting);
        file_put_contents("setting.json","$option");
        $num=0;
        $list=array();
        foreach($setting as $key=>$value){
          $list[$num]=array(array("text"=>"$key","callback_data"=>"$key"),array("text"=>"$value","callback_data"=>"$key:$value"));
          $num++;
        }
        bot("editMessageReplyMarkup",[
        "chat_id"=>$cl_chatid,
        "message_id"=>$cl_msgid,
        "reply_markup"=>json_encode(["inline_keyboard"=>$list])
        ]);
        bot("answerCallbackQuery",[
          "callback_query_id"=>$up->callback_query->id,
          "text"=>"انجام شد."
        ]);
      }elseif($data=="videoNote:yes"){
        $setting["videoNote"]="no";
        $option=json_encode($setting);
        file_put_contents("setting.json","$option");
        $num=0;
        $list=array();
        foreach($setting as $key=>$value){
          $list[$num]=array(array("text"=>"$key","callback_data"=>"$key"),array("text"=>"$value","callback_data"=>"$key:$value"));
          $num++;
        }
        bot("editMessageReplyMarkup",[
        "chat_id"=>$cl_chatid,
        "message_id"=>$cl_msgid,
        "reply_markup"=>json_encode(["inline_keyboard"=>$list])
        ]);
       bot("answerCallbackQuery",[
          "callback_query_id"=>$up->callback_query->id,
          "text"=>"انجام شد."
        ]);
      }elseif($data=="videoNote:no"){
        $setting["videoNote"]="yes";
        $option=json_encode($setting);
        file_put_contents("setting.json","$option");
        $num=0;
        $list=array();
        foreach($setting as $key=>$value){
          $list[$num]=array(array("text"=>"$key","callback_data"=>"$key"),array("text"=>"$value","callback_data"=>"$key:$value"));
          $num++;
        }
       bot("editMessageReplyMarkup",[
        "chat_id"=>$cl_chatid,
        "message_id"=>$cl_msgid,
        "reply_markup"=>json_encode(["inline_keyboard"=>$list])
        ]);
        bot("answerCallbackQuery",[
          "callback_query_id"=>$up->callback_query->id,
          "text"=>"انجام شد."
        ]);
      }elseif($data=="audio:yes"){
        $setting["audio"]="no";
        $option=json_encode($setting);
        file_put_contents("setting.json","$option");
        $num=0;
        $list=array();
        foreach($setting as $key=>$value){
          $list[$num]=array(array("text"=>"$key","callback_data"=>"$key"),array("text"=>"$value","callback_data"=>"$key:$value"));
          $num++;
        }
        bot("editMessageReplyMarkup",[
        "chat_id"=>$cl_chatid,
        "message_id"=>$cl_msgid,
        "reply_markup"=>json_encode(["inline_keyboard"=>$list])
        ]);
        bot("answerCallbackQuery",[
          "callback_query_id"=>$up->callback_query->id,
          "text"=>"انجام شد."
        ]);
      }elseif($data=="audio:no"){
        $setting["audio"]="yes";
        $option=json_encode($setting);
        file_put_contents("setting.json","$option");
        $num=0;
        $list=array();
        foreach($setting as $key=>$value){
          $list[$num]=array(array("text"=>"$key","callback_data"=>"$key"),array("text"=>"$value","callback_data"=>"$key:$value"));
          $num++;
        }
        bot("editMessageReplyMarkup",[
        "chat_id"=>$cl_chatid,
        "message_id"=>$cl_msgid,
        "reply_markup"=>json_encode(["inline_keyboard"=>$list])
        ]);
        bot("answerCallbackQuery",[
          "callback_query_id"=>$up->callback_query->id,
          "text"=>"انجام شد."
        ]);
      }elseif($data=="voice:yes"){
        $setting["voice"]="no";
        $option=json_encode($setting);
        file_put_contents("setting.json","$option");
        $num=0;
        $list=array();
        foreach($setting as $key=>$value){
          $list[$num]=array(array("text"=>"$key","callback_data"=>"$key"),array("text"=>"$value","callback_data"=>"$key:$value"));
          $num++;
        }
        bot("editMessageReplyMarkup",[
        "chat_id"=>$cl_chatid,
        "message_id"=>$cl_msgid,
        "reply_markup"=>json_encode(["inline_keyboard"=>$list])
        ]);
        bot("answerCallbackQuery",[
          "callback_query_id"=>$up->callback_query->id,
          "text"=>"انجام شد."
        ]);
      }elseif($data=="voice:no"){
        $setting["voice"]="yes";
        $option=json_encode($setting);
        file_put_contents("setting.json","$option");
        $num=0;
        $list=array();
        foreach($setting as $key=>$value){
          $list[$num]=array(array("text"=>"$key","callback_data"=>"$key"),array("text"=>"$value","callback_data"=>"$key:$value"));
          $num++;
        }
        bot("editMessageReplyMarkup",[
        "chat_id"=>$cl_chatid,
        "message_id"=>$cl_msgid,
        "reply_markup"=>json_encode(["inline_keyboard"=>$list])
        ]);
        bot("answerCallbackQuery",[
          "callback_query_id"=>$up->callback_query->id,
          "text"=>"انجام شد."
        ]);
      }elseif($data=="document:yes"){
        $setting["document"]="no";
        $option=json_encode($setting);
        file_put_contents("setting.json","$option");
        $num=0;
        $list=array();
        foreach($setting as $key=>$value){
          $list[$num]=array(array("text"=>"$key","callback_data"=>"$key"),array("text"=>"$value","callback_data"=>"$key:$value"));
          $num++;
        }
        bot("editMessageReplyMarkup",[
        "chat_id"=>$cl_chatid,
        "message_id"=>$cl_msgid,
        "reply_markup"=>json_encode(["inline_keyboard"=>$list])
        ]);
        bot("answerCallbackQuery",[
          "callback_query_id"=>$up->callback_query->id,
          "text"=>"انجام شد."
        ]);
      }elseif($data=="document:no"){
        $setting["document"]="yes";
        $option=json_encode($setting);
        file_put_contents("setting.json","$option");
        $num=0;
        $list=array();
        foreach($setting as $key=>$value){
          $list[$num]=array(array("text"=>"$key","callback_data"=>"$key"),array("text"=>"$value","callback_data"=>"$key:$value"));
          $num++;
        }
        bot("editMessageReplyMarkup",[
        "chat_id"=>$cl_chatid,
        "message_id"=>$cl_msgid,
        "reply_markup"=>json_encode(["inline_keyboard"=>$list])
        ]);
        bot("answerCallbackQuery",[
          "callback_query_id"=>$up->callback_query->id,
          "text"=>"انجام شد."
        ]);
      }elseif($data=="profile"){
        bot("editMessageText",[
          "chat_id"=>$cl_chatid,
          "text"=>file_get_contents("profile.txt"),
          "message_id"=>$cl_msgid,
          "reply_markup"=>json_encode(["inline_keyboard"=>[[["text"=>"بازگشت 🔙","callback_data"=>"back"],["text"=>"تغییر 🖊","callback_data"=>"changeprofile"]]]])
        ]);
      }elseif($data=="dasturjadid"){
        file_put_contents("sudo.txt","dasturjadid");
        bot("sendMessage",[
          "chat_id"=>$cl_chatid,
          "text"=>"_لطفا دستور خود را ارسال کنید._",
          "parse_mode"=>"markdown",
          "reply_markup"=>json_encode(["resize_keyboard"=>true,"keyboard"=>[[["text"=>"لغو"]]]])
        ]);
      }elseif($data=="changeprofile"){
        file_put_contents("sudo.txt","profile");
        bot("sendMessage",[
          "chat_id"=>$cl_chatid,
          "text"=>"_لطفا پیام خود را که فقط حاوی متن باشد ارسال کنید._",
          "parse_mode"=>"markdown",
          "reply_markup"=>json_encode(["resize_keyboard"=>true,"keyboard"=>[[["text"=>"لغو"]]]])
        ]);
      }elseif($data=="forward2"){
        file_put_contents("sudo.txt","forward2");
        bot("sendMessage",[
          "chat_id"=>$cl_chatid,
          "text"=>"_لطفا پیام خود را ارسال کنید._",
          "parse_mode"=>"markdown",
          "reply_markup"=>json_encode(["resize_keyboard"=>true,"keyboard"=>[[["text"=>"لغو"]]]])]);
      }elseif($data=="createmenu"){
        file_put_contents("sudo.txt","createmenu");
        bot("sendMessage",[
          "chat_id"=>$cl_chatid,
          "text"=>"لطفا نام منو خود را ارسال کنید.",
          "reply_markup"=>json_encode(["resize_keyboard"=>true,"keyboard"=>[[["text"=>"لغو"]]]])]);
      }elseif($data=="managementmenu"){
        $list=array();
        $json=json_decode(file_get_contents("dasturat.json"),true);
        foreach($json as $key=>$value){
          if($json[$key]["type"]=="menu"){
            $list[$key]=array(array("text"=>"$key"));
          }
        }
        $list=array_values($list);
        if(count($list!=0)){
          bot("sendMessage",[
            "chat_id"=>$cl_chatid,
            "text"=>"منو و زیر منو های موجود.",
            "reply_markup"=>json_encode(["resize_keyboard"=>true,"keyboard"=>$list])
          ]);       
        }else{
          bot("sendMessage",[
            "chat_id"=>$cl_chatid,
            "text"=>"منو و زیر منویی موجود نیست."]);
        }
      }elseif($data=="deletemenu"){
        $json=json_decode(file_get_contents("dasturat.json"),true);
        $list=array();
        foreach($json as $key=>$value){
          if($json[$key]["type"]=="menu"){
            $list[$key]=array(array("text"=>"$key"));
          }
        }
        $list=array_values($list);
        if(count($list)!=0){
          file_put_contents("sudo.txt","deletemenu");
          $list[count($list)]=array(array("text"=>"لغو"));
          bot("sendMessage",[
            "chat_id"=>$cl_chatid,
            "text"=>"منو و زیر منو های موجود.",
            "reply_markup"=>json_encode(["resize_keyboard"=>true,"keyboard"=>$list])
          ]);
        }else{
          bot("sendMessage",[
            "chat_id"=>$cl_chatid,
            "text"=>"منو و زیر منویی موجود نیست."]);
        }
      }elseif($data=="forward"){
        file_put_contents("sudo.txt","forward");
        bot("sendMessage",[
          "chat_id"=>$cl_chatid,
          "text"=>"_لطفا پیام خود را ارسال کنید._",
          "parse_mode"=>"markdown",
          "reply_markup"=>json_encode(["resize_keyboard"=>true,"keyboard"=>[[["text"=>"لغو"]]]])]);
      }elseif($data=="start"){
        $txt=file_get_contents("start.txt");
        bot("editMessageText",[
          "chat_id"=>$cl_chatid,
          "text"=>"$txt",
          "message_id"=>$cl_msgid,
          "reply_markup"=>json_encode(["inline_keyboard"=>[[["text"=>"بازگشت 🔙","callback_data"=>"back"],["text"=>"تغییر 🖊","callback_data"=>"changestart"]]]])
        ]);
      }elseif($data=="changestart"){
        file_put_contents("sudo.txt","start");
        bot("sendMessage",[
          "chat_id"=>$cl_chatid,
          "text"=>"_لطفا پیام خود را که فقط حاوی متن باشد ارسال کنید.کلمات زیر جایگزین خواهند شد.\nuserid با آیدی فرد\nfirstname با نام فرد\nlastname با نام خانوادگی فرد\nusername با یوزرنیم فرد._",
          "parse_mode"=>"markdown",
          "reply_markup"=>json_encode(["resize_keyboard"=>true,"keyboard"=>[[["text"=>"لغو"]]]])
        ]);
      }elseif($data=="block"){
        $array=explode("\n",str_replace("block\n","",file_get_contents("block.txt")));
        if($array[0]!="block"){
          $list=array();
          foreach($array as $key=>$value){
            $list[$key]=array(array("text"=>"$value","callback_data"=>"$value"));
          }
          bot("sendMessage",[
            "chat_id"=>$cl_chatid,
            "text"=>"_>>>بلاک لیست<<<_",
            "parse_mode"=>"markdown",
            "reply_markup"=>json_encode(array("inline_keyboard"=>$list))
          ]);
        }else{
          bot("sendMessage",[
          "chat_id"=>$cl_chatid,
          "text"=>"_بلاک لیست خالی است._",
          "parse_mode"=>"markdown"
          ]);
        }
      }else{
        file_put_contents("block.txt",str_replace("\n$data","",file_get_contents("block.txt")));
        bot("sendMessage",[
          "chat_id"=>$data+0,
          "text"=>"_شما ازبلاک خارج شدید._",
          "parse_mode"=>"markdown"
        ]);
        $array=explode("\n",str_replace("block\n","",file_get_contents("block.txt")));
        if($array[0]!="block"){
          $list=array();
          foreach($array as $key=>$value){
            $list[$key]=array(array("text"=>"$value","callback_data"=>"$value"));
          }
          bot("editMessageReplyMarkup",[
            "chat_id"=>$cl_chatid,
            "message_id"=>$cl_msgid, "reply_markup"=>json_encode(array("inline_keyboard"=>$list))
          ]);
        }else{
          bot("editMessageText",[
            "chat_id"=>$cl_chatid,
            "message_id"=>$cl_msgid,
            "text"=>"_بلاک لیست خالی است._",
            "parse_mode"=>"markdown"
          ]);
        }
      }
    }else{
      bot("answerCallbackQuery",[
        "callback_query_id"=>$up->callback_query->id,
        "text"=>"شما در حال انجام عملیات دیگری هستید.ابتدا آن را لغو کنید.",
        "show_alert"=>true
      ]);
    }
  }else{
    bot("answerCallbackQuery",[
        "callback_query_id"=>$up->callback_query->id,
        "text"=>"شما ادمین ربات نیستید.
       ",
        "show_alert"=>true
      ]);
  }
}
  unlink("error_log");
  /*
✲ کانال زتو تی ام  ✲ به کانال ما برای دریافت سورس های بیشتر سر بزنید :) @Zeto_TM
*/
?>

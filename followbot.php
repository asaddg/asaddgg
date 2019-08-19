<?php
error_reporting(0);
ob_start();
define('API_KEY','894863856:AAF2aHvoSxjSXSewJScUkSao6coNC-FHvR8');
function bot($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."492527820/".$method;
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
//-----------------[متغیر ها]--------------------//
$update = json_decode(file_get_contents("php://input"));
$message = $update->message;
$text = $update->message->text;
$chat_id = $update->message->chat->id;
$from_id = $update->message->from->id;
$message_id = $update->message->message_id;
$first_name = $update->message->from->first_name;
$first = $update->callback_query->from->first_name;
$last_name = $update->callback_query->from->last_name;
$username = $update->callback_query->from->username;
$username2 = $update->message->from->username;
$data = $update->callback_query->data;
$from_id = $message->from->id;
$chatid = $update->callback_query->message->chat->id;
$messageid = $update->callback_query->message->message_id;
$forward_username = $update->message->forward_from_chat->username;
$reply = $message->reply_to_message->forward_from->id;
$reply_username = $message->reply_to_message->forward_from->username;
$kanal = "turkhackam";
$channel = "turkhackam";
$support = "azarat_turkam";
$token = "813989645:AAHIlJkNEr7hPCJnkaMHFJ4b9v5-5Zj29Ok";
$forchannel = json_decode(file_get_contents("https://api.telegram.org/bot".$token."/getChatMember?chat_id=@$kanal&user_id=".$chat_id));
$tch = $forchannel->result->status;
mkdir("data/$chat_id");
$step = file_get_contents("data/$chat_id/step.txt");
$mnmf = file_get_contents("data/$chat_id/mehdi.txt");
$user = file_get_contents("data/insta.txt");
$code = file_get_contents("data/code.txt");
$sec = file_get_contents("data/sec.txt");
$command = file_get_contents("data/$chat_id/command.txt");
$step = file_get_contents("data/$from_id/step.txt");
$ban = file_get_contents("data/ban.txt");
$admin = "ایدی ادمین";
$load = sys_getloadavg();
//----------------------------//
function SendMessage($chat_id,$text,$keyboard){
	bot('SendMessage',[
	'chat_id'=>$chat_id,
	'text'=>$text,
	'reply_markup'=>$keyboard]);
}
function edit($chat_id,$meesage_id,$text,$reply_markup){
	bot('editMessageText',[
	'chat_id'=>$chat_id,
	'message_id'=>$message_id,
	'text'=>$text,
	'reply_markup'=>$reply_markup]);
}
function save($filename, $data)
{
$file = fopen($filename, 'w');
fwrite($file, $data);
fclose($file);
}
function ForwardMessage($chatid,$from_chat,$message_id){
	bot('ForwardMessage',[
	'chat_id'=>$chatid,
	'from_chat_id'=>$from_chat,
	'message_id'=>$message_id]);
}
//-----------------دستورها--------------------//
if(strpos($ban,"$chat_id") !== false && $chat_id != $admin){
	bot('SendMessage',[
	'chat_id'=>$chat_id,
	'text'=>"شما از سرور ما بلاک شده اید❗️"]);
	return false;
}
elseif(strpos($ban,"$chat_id") !== false && $chatid != $admin){
	bot('SendMessage',[
	'chat_id'=>$chatid,
	'message_id'=>$messageid,
	'text'=>"🔺شما مسدود شده اید 🔺"]);
	return false;
}
if($text == "/start"){
	if($tch == 'member' or $tch == 'creator' or $tch == 'administrator'){
		$user = file_get_contents('Member.txt');
	$members = explode("\n",$user);
	if(!in_array($chat_id,$members)){
		$add_user = file_get_contents('Member.txt');
		$add_user .= $chat_id."\n";
		file_put_contents('Member.txt',$add_user);
	}
  bot('SendMessage',[
  'chat_id'=>$chat_id,
  'text'=>"ایدی عددی اکانت خودتو رو بفرست 🙁❤️

ایدی رو فقط بصورت زیر ارسال کن  در هر مرحله در صورتی که خواستی ایدی جدید ثبت یا ایدی قبلی خودت رو عوض کنی کافیه مجدد طبق الگوریتم زیر ایدی تو بفرستی تا ثبت بشه


🚨 مثال:
/userایدی عددی 

/user12345678
حواست باشه ایدی خودتو  رو مثل بالا بدون فاصله بین حروف و اعداد بالا بفرستی هااا️",
  'pars_mode'=>'html',
]);
}else {
    bot('sendmessage', [
        'chat_id' => $chat_id,
        'text' => "سلام به ربات فالو بومبر خوش اومدی😃💋
عزیز اولین کار اینکه در کانال ما جوین شی☑️👇🏿
@$channel
@$channel 
بعد جوین شدن کلمه /start رو بزن✅"
    ]);
    return false;
}
}
if($text == "🔙بازگشت"){
    bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"به ربات ما خوش امدید
چه کاری از دستم برمیاد؟؟؟؟؟؟؟",
'parse_mode'=>"html",
'reply_to_message_id'=>$message_id,  
'reply_markup'=>json_encode([
'keyboard'=>[
[
['text'=>"♦️ثبت لایسنس♦️"],
],
[
['text'=>"💌 راهنما 💌"],['text'=>"👮‍♂️♂ پشتیبانی 👮‍♂️♂"]
],
[
['text'=>"کانال ما🍓🍑"],
]
],
'resize_keyboard'=>true
])
]);
}
if(strpos( $text ,'/user') !== false){
 $text = str_replace('/user','',$text); 
save("data/insta.txt",$text);
 bot('sendMessage',[
        'chat_id'=>$chat_id,
         'text'=>"اطللاعات شما تکمیل شد✅

لطفا یکی از گزینه های زیر را انتخاب کنید 🙁❤️",
'reply_to_message_id'=>$message_id,  
'reply_markup'=>json_encode([
'keyboard'=>[
[
['text'=>"♦️ثبت لایسنس♦️"],
],
[
['text'=>"💌 راهنما 💌"],['text'=>"👮‍♂️♂ پشتیبانی 👮‍♂️♂"]
],
[
['text'=>"کانال ما🍓🍑"],
]
],
'resize_keyboard'=>true
])
]);
}
elseif($text == "♦️ثبت لایسنس♦️"){
file_put_contents("data/$from_id/step.txt","learn");
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"کاربر گرامی کد جهت ورود به ربات را وارد کنید:

📌 در صورتی که کد را خریداری نکرده اید از طریق دکمه زیر به پشتیبانی مراجعه کرده
و کد را دریافت و در همین قسمت وارد کنید",
'parse_mode'=>"html",
 'reply_to_message_id'=>$message_id,
'reply_markup'=>json_encode([
'keyboard'=>[
[
['text'=>"🔙بازگشت"],
],
],
'resize_keyboard'=>true
])
]);
}
elseif($step == "learn"){
if($text == $code){
$bede = $coin+$sec;
file_put_contents("data/$from_id/coin.txt",$bede);
file_put_contents("data/$from_id/step.txt","end");
unlink("data/code.txt");
bot('sendmessage',[
  'chat_id'=>$chat_id,
  'text'=>"لایسنس با موفقیت ثبت شد🌹
چیکار میخای برات بکنم🤨",
  'pars_mode'=>'html',
  'reply_markup'=>json_encode(['inline_keyboard'=>[
  [['text'=>"🚀  دریافت فالور 🚀",'callback_data'=>"send"]],
  [['text'=>"👮‍♂️ پشتیبانی 👮‍♂️",'url'=>"https://t.me/$support"],['text'=>"کانال ما🍓🍑",'url'=>"https://t.me/$channel"]],
  ],'resize_keyboard'=>true])
  ]);
bot('sendmessage',[
'chat_id'=>$admin,
'text'=>"💥 کاربر  =>  $from_id

⚡️ کد => $code

⚡️نام کد =>  $sec

را با موفقیت استفاده کرد✅",
]);
}
}
if($text == "💌 راهنما 💌"){
    bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"با سلام دوست عزیز این ربات متعلق به تورک هک میباشد 🙃
با این ریات فالور هاتو بینهایت کن😳☑️
اگه لایسنس نداری از ایدی زیر لایسنس با قیمت ارزون بخر😄👇🏿
@$support",
'parse_mode'=>"html",
 'reply_to_message_id'=>$message_id,
'reply_markup'=>json_encode([
'keyboard'=>[
[
['text'=>"🔙بازگشت"],
],
],
'resize_keyboard'=>true
])
]);
}
if($text == "👮‍♂️♂ پشتیبانی 👮‍♂️♂"){
    bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"اگه کاری جیزی درباره ربات داشتی به این ایدی پیام بده♣️👇🏿",
'parse_mode'=>"html",
'reply_to_message_id'=>$message_id,  
  'reply_markup'=>json_encode(['inline_keyboard'=>[
  [['text'=>"▫️ ارتباط با پشتیبان ▫️",'url'=>"https://t.me/$support"]],
  ],'resize_keyboard'=>true])
  ]);
}
if($text == "کانال ما🍓🍑"){
    bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"🖇 جهت ورود به کانال ما  و حمایت از ما  از طریق دکمه زیر عضو کانال ما شده

🔻 جهت ورود از دکمه زیر اقدام کنید 🔺",
'parse_mode'=>"html",
  'reply_markup'=>json_encode(['inline_keyboard'=>[
  [['text'=>"▫️ورود به کانال  ▫️",'url'=>"https://t.me/$channel"]],
  ],'resize_keyboard'=>true])
  ]);
}
elseif($data == "send"){
$follow = file_get_contents("https://www.turkhackam1.telmizban.ml/Paaanel/api.php?linkId=$user");
  bot('editMessageText',[
  'chat_id'=>$chatid,
  'message_id'=>$messageid,
 'text'=>"♻️ سفارش شما درحال انجام است ♻️
 ☑️لطفا بعد 7 الی 10 دقیقه بعد سفارش دیگری ثبت کنید در غیر این صورت از ربات مسدود خواهید شد و پشتیبانی هیچکاری نمیتونه بکنه🤷‍♀️♂🙏🏿♥️ 
$follow",
  'pars_mode'=>'html',
  'reply_markup'=>json_encode(['inline_keyboard'=>[
  [['text'=>"▫️ ارتباط با پشتیبان ▫️",'url'=>"https://t.me/$support"]],
  ],'resize_keyboard'=>true])
  ]);
bot('sendmessage',[
'chat_id'=>$admin,
'text'=>"🌟 کاربر ی برای پیچ

$user

یک سفارش ثبت کرد ✅

📌وضعیت :
🚦 در حال واریز ...",
]);
}
elseif($text == "/code" and $from_id == $admin){
  file_put_contents("data/$from_id/step.txt","name");
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"💥لطفا یک کد برای ساخت لیسانس وارد کنید:",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'keyboard'=>[
[
['text'=>"🔙بازگشت"],
],
],
'resize_keyboard'=>true
])
]);
}  
if($step == "name"){
file_put_contents("data/code.txt",$text);
file_put_contents("data/$from_id/step.txt","te");
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"تایید شد ✅

✨ یک نام جهت شناسایی کد ارسال کنید:",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'keyboard'=>[
[
['text'=>"🔙بازگشت"],
],
],
'resize_keyboard'=>true
])
]);
}
if($step == "te"){
file_put_contents("data/sec.txt",$text);
file_put_contents("data/$from_id/step.txt","end");
$code = file_get_contents("data/code.txt");
$sec = file_get_contents("data/sec.txt");
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"♻️ در حال ساخت .....",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'keyboard'=>[
[
['text'=>"🔙بازگشت"],
],
],
'resize_keyboard'=>true
])
]);
bot('sendmessage',[
 'chat_id'=>$admin,
'text'=>"لیسانس مورد نظر شما با موفقیت ساخته شد✅

🔖 کد : $code
⚡️ نام انتخابی : $sec

موفق باشید ❣️",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'keyboard'=>[
[
['text'=>"🔙بازگشت"],
],
],
'resize_keyboard'=>true
])
]);
}
//----------------------------//
elseif($text == "/panel" and $from_id == $admin){
	bot('SendMessage',[
	'chat_id'=>$chat_id,
	'text'=>"سلام قربان به پنل مدیریت ربات خوش امدید 👮🏻‍♂️

💪🏻 در خدمتم .....!",
	'pars_mode'=>'html',
	'reply_markup'=>json_encode(['inline_keyboard'=>[
	[['text'=>"
➕ امار ➕",'callback_data'=>"am"]],
	[['text'=>"📣 فروارد همگانی 📣",'callback_data'=>"forr"],['text'=>"🔊 پیام همگانی 🔊",'callback_data'=>"ersal"]],
		[['text'=>"🎯وضعیت ربات",'callback_data'=>"ping"]],
		[['text'=>"➕ ساختن لایسنس ➕",'callback_data'=>"code"]],	
				[['text'=>"➖حذف لیسانس➖",'callback_data'=>"delcode"]],	
				[['text'=>"🔹انبن کردن کاربر",'callback_data'=>"unlo"],['text'=>"♦️بن کردن کاربر",'callback_data'=>"blo"]],
	[['text'=>"📍لیست مسدود ها",'callback_data'=>"listt"]],	
	],'resize_keyboard'=>true])
	]);
}
elseif($data == "am" and $chatid == $admin){
	$user = file_get_contents('Member.txt');
	$member = explode("\n",$user);
	$mehdi = count($member)-1;
	bot('editMessageText',[
	'chat_id'=>$chatid,
	'message_id'=>$messageid,
	'text'=>"آمار ربات
	$mehdi",
	'pars_mode'=>'html',
'reply_markup'=>json_encode(['inline_keyboard'=>[
[['text'=>"برگشت به پنل مدیریت",'callback_data'=>"panel"]],
],'resize_keyboard'=>true])
]);
}
elseif($data == "ersal" and $chatid == $admin){
	save("data/$chatid/step.txt","sendall");
	bot('editMessageText',[
	'chat_id'=>$chatid,
	'message_id'=>$messageid,
	'text'=>"پیام خود را در قالب متن ارسال کنید تا به دست همه برسانم.",
	'pars_mode'=>'html',
	'reply_markup'=>json_encode(['inline_keyboard'=>[
	[['text'=>"🔙 بازگشت به پنل",'callback_data'=>"panel"]],
	],'resize_keyboard'=>true])
	]);
}
elseif($step == "sendall"){
	save("data/$chat_id/step.txt","none");
		bot('SendMessage',[
		'chat_id'=>$admin,
		'text'=>"پیام با موفقیت به دست همه رسید.",
		'pars_mode'=>'html',
	'reply_markup'=>json_encode(['inline_keyboard'=>[
	[['text'=>"🔙 بازگشت به پنل",'callback_data'=>"panel"]],
	],'resize_keyboard'=>true])
	]);
		$mem = fopen("Member.txt",'r');
		while(!feof($mem)){
			$memuser = fgets($mem);
			bot('SendMessage',[
			'chat_id'=>$memuser,
			'text'=>$text]);
	}
}
elseif($data == "forr" and $chatid == $admin){
	save("data/$chatid/command.txt","forr");
	bot('editMessageText',[
	'chat_id'=>$chatid,
	'message_id'=>$messageid,
	'text'=>"پیام مورد نظر خود را فروارد کنید تا به دست همه برسونم.",
	'pars_mode'=>'html',
	'reply_markup'=>json_encode(['inline_keyboard'=>[
	[['text'=>"🔙 بازگشت به پنل",'callback_data'=>"panel"]],
	],'resize_keyboard'=>true])
	]);
}
elseif($command == "forr"){
	save("data/$chat_id/command.txt","none");
	$forp = fopen("Member.txt",'r');
	while(!feof($forp)){
		$fakar = fgets($forp);
	bot('ForwardMessage',[
	'chat_id'=>$fakar,
	'from_chat_id'=>$admin,
	'$message_id'=>$message_id]);
	}
	bot('SendMessage',[
	'chat_id'=>$chat_id,
	'text'=>"پیام شما به تمامی کاربران فروارد شد.",
	'pars_mode'=>'html',
	'reply_markup'=>json_encode(['inline_keyboard'=>[
	[['text'=>"🔙 بازگشت به پنل",'callback_data'=>"panel"]],
	],'resize_keyboard'=>true])
	]);
}
elseif($data == "ping" and $chatid == $admin){
	bot('editMessageText',[
	'chat_id'=>$chatid,
	'message_id'=>$messageid,
	'text'=>"📍PING ; $load[0] ",
	'pars_mode'=>'html',
	'reply_markup'=>json_encode(['inline_keyboard'=>[
	[['text'=>"🔙 بازگشت به پنل",'callback_data'=>"panel"]],
  ],'resize_keyboard'=>true])
  ]);
}
elseif($data == "code" and $chatid == $admin){
	bot('editMessageText',[
	'chat_id'=>$chatid,
	'message_id'=>$messageid,
	'text'=>"جهت ساخت کد دستور 
/code را ارسال کنید

توجه کنید این صفحه فقط یرای راهنمای ادمین است و درصورت به خاطر سپردن
دستور /code
دیگر لازم نیست این صفحه را باز کنید",
	'pars_mode'=>'html',
	'reply_markup'=>json_encode(['inline_keyboard'=>[
	[['text'=>"🔙 بازگشت به پنل",'callback_data'=>"panel"]],
  ],'resize_keyboard'=>true])
  ]);
}
elseif($data == "delcode" and $chatid == $admin){
	bot('editMessageText',[
	'chat_id'=>$chatid,
	'message_id'=>$messageid,
	'text'=>"جهت حذف کد دستور 
/delcode را ارسال کنید

توجه کنید این صفحه فقط یرای راهنمای ادمین است و درصورت به خاطر سپردن
دستور /delcode
دیگر لازم نیست این صفحه را باز کنید",
	'pars_mode'=>'html',
	'reply_markup'=>json_encode(['inline_keyboard'=>[
	[['text'=>"🔙 بازگشت به پنل",'callback_data'=>"panel"]],
  ],'resize_keyboard'=>true])
  ]);
}
elseif($data == "panel" and $chatid == $admin){
	bot('editMessageText',[
	'chat_id'=>$chatid,
	'message_id'=>$messageid,
	'text'=>"به پنل مدیریت بازگشتید.
	
	
	چه کاری از دستم برمیاد؟",
	'pars_mode'=>'html',
		'reply_markup'=>json_encode(['inline_keyboard'=>[
	[['text'=>"
➕ امار ➕",'callback_data'=>"am"]],
	[['text'=>"📣 فروارد همگانی 📣",'callback_data'=>"forr"],['text'=>"🔊 پیام همگانی 🔊",'callback_data'=>"ersal"]],
		[['text'=>"🎯وضعیت ربات",'callback_data'=>"ping"]],
		[['text'=>"➕ ساختن لایسنس ➕",'callback_data'=>"code"]],	
	],'resize_keyboard'=>true])
	]);
}
elseif($text == "/delcode" and $from_id == $admin){
    file_put_contents("data/$from_id/step.txt","cvip");
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"ادمین گرامی🔖

کد مورد نظری که قصد حذف انرا دارید ارسال کنید:",
'parse_mode'=>"html",
 'reply_to_message_id'=>$message_id,
'reply_markup'=>json_encode([
'keyboard'=>[
[
['text'=>"🔙بازگشت"],
],
],
'resize_keyboard'=>true
])
]);
}
elseif($data == "blo" and $chatid == $admin){
	save("data/$chatid/command.txt","ban");
	bot('editMessageText',[
	'chat_id'=>$chatid,
	'message_id'=>$messageid,
	'text'=>"آیدی عددی کاربری که میخواهید بلاک کنید را بفرستید تا بلاکش کنم.",
	'pars_mode'=>'html',
	'reply_markup'=>json_encode(['inline_keyboard'=>[
[['text'=>"برگشت به پنل مدیریت",'callback_data'=>"panel"]],
	],'resize_keyboard'=>true])
	]);
}
elseif($command == 'ban'){
	save("data/$chat_id/command.txt","none");
	$myfile2 = fopen("data/ban.txt","a") or die("Unable to open file!");
	fwrite($myfile2,"$text\n");
	fclose($myfile2);
	bot('SendMessage',[
	'chat_id'=>$chat_id,
	'text'=>"کاربر مورد نظر با موفقیت بلاک شد.",
	'pars_mode'=>'html',
	'reply_markup'=>json_encode(['inline_keyboard'=>[
[['text'=>"برگشت به پنل مدیریت",'callback_data'=>"panel"]],
	],'resize_keyboard'=>true])
	]);
	bot('SendMessage',[
	'chat_id'=>$text,
	'text'=>"شما کاربر عزیز توسط ادمین بلاک شدید"]);
}
elseif($data == "unlo" and $chatid == $admin){
	save("data/$chatid/command.txt","unban");
	bot('editMessageText',[
	'chat_id'=>$chatid,
	'message_id'=>$messageid,
	'text'=>"آیدی عددی کاربری که میخواهید آنبلاکش کنید رو بفرستید تا آنبلاکش کنم.",
	'pars_mode'=>'html',
	'reply_markup'=>json_encode(['inline_keyboard'=>[
[['text'=>"برگشت به پنل مدیریت",'callback_data'=>"panel"]],
	],'resize_keyboard'=>true])
	]);
}
elseif($command == 'unban'){
	save("data/$chat_id/command.txt","none");
	$newlist = str_replace($text,"",$ban);
	save("data/ban.txt",$newlist);
	bot('SendMessage',[
	'chat_id'=>$chat_id,
	'text'=>"کاربر مورد نظر با موفقیت آنبلاک شد.",
	'pars_mode'=>'html',
	'reply_markup'=>json_encode(['inline_keyboard'=>[
[['text'=>"برگشت به پنل مدیریت",'callback_data'=>"panel"]],
	],'resize_keyboard'=>true])
	]);
	bot('SendMessage',[
	'chat_id'=>$text,
	'text'=>"شما کاربر عزیز توسط ادمین با موفقیت از بلاک خارج شدید."]);
}
elseif($data == "listt" and $chatid == $admin){
		$ban = file_get_contents("data/ban.txt");
			bot('editMessageText',[
			'chat_id'=>$chatid,
			'message_id'=>$messageid,
			'text'=>"آیدی عددی کاربران بلاک شده:
			
			$ban",
			'pars_mode'=>'html',
	'reply_markup'=>json_encode(['inline_keyboard'=>[
[['text'=>"برگشت به پنل مدیریت",'callback_data'=>"panel"]],
	],'resize_keyboard'=>true])
	]);
}
elseif($step == "cvip"){
if($text == $code){
$bede = $coin+$sec;
file_put_contents("data/$from_id/coin.txt",$bede);
file_put_contents("data/$from_id/step.txt","end");
unlink("data/code.txt");
bot('sendmessage',[
  'chat_id'=>$chat_id,
  'text'=>"کد مورد نظر شما با موفقیت حذف شد ✅",
  'pars_mode'=>'html',
  'reply_markup'=>json_encode(['inline_keyboard'=>[
	[['text'=>"🔙 بازگشت به پنل",'callback_data'=>"panel"]],
  ],'resize_keyboard'=>true])
  ]);
}
}
?>

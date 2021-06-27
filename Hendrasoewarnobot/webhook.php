<?php
/*
Buat sertifikat:
https://www.selfsignedcertificate.com/

Convert cert menjadi pem
openssl x509 -in cert.cer -out cert.pem

Mengupload sertifikat Self-signed ke telegram
curl -F "url=https://ec2-3-15-196-245.us-east-2.compute.amazonaws.com/Hendrasoewarnobot/webhook.php" -F "certificate=@/etc/ssl/myCerts/72576561_ec2-3-15-196-245.us-east-2.compute.amazonaws.com.pem" https://api.telegram.org/bot1863288706:AAGC0d01Gv0Ag55p7J65PHPOwggTRUmh7HY/setWebhook
*/

define('BOT_TOKEN', '1863288706:AAGC0d01Gv0Ag55p7J65PHPOwgg********');
define('API_URL', 'https://api.telegram.org/bot'.BOT_TOKEN.'/');
define('MESSAGE', 0);
define('CALLBACK', 1);

function logger($text){
	$fh = fopen("log/log.txt", 'a') or die("can't open file");
	fwrite($fh, str_replace("\t","",$text)."\n\n");
	fclose($fh);
}

class Bot {
	private $con;
	private $obj;
	private $objType;
	private $fromId;
	private $chatId;
	private $response;
	private $keyboard="";
	
	function __construct($body) {
		logger($body);
		$this->obj = json_decode($body); //object
		if (isset($this->obj->message)) {
			$this->objType = MESSAGE;
			$this->fromId = $this->obj->message->from->id;
		}
		else {
			$this->objType = CALLBACK;
			$this->fromId = $this->obj->callback_query->from->id;
		}
	}
	
	function getFormId() {
		return $this->formId;
	}
	
	//User Message adalah perintah yang diawali dengan / (seperti /start)
	function processUserMessage(){
		$ret = "";
		$this->chatId = $this->obj->message->chat->id;	
		$date = $this->obj->message->date;
		$text = $this->obj->message->text;
		if (strpos($text, '/start')===0) {
			$this->response = "Selamat datang ke bot Hendrasoewarnobot";
			//ini contoh kalau mau buat keyboard
			$keyboard = array(
				"inline_keyboard" => array(
					array(
						array("text" => "\xE2\x9C\x8F Register", "one_time_keyboard" => false, "callback_data" => "1"),
						array("text" => "\xE2\x98\x91 Verify Account", "one_time_keyboard" => false, "callback_data" => "2")
					)
				)
			);
			$this->keyboard = json_encode($keyboard, true);
		} elseif (strpos($text, '/reg')===0) {
			$this->response = "belum diimplementasikan";
		} else {
			$this->response = "perintah tidak dikenali!";
		}
	}

	//User Response adalah balasan dari user tanpa diawali /
	function processUserCallback() {
		$ret = "";
		$this->chatId = $this->obj->callback_query->message->chat->id;
		$date = $this->obj->callback_query->message->date;
		$data = $this->obj->callback_query->data;
		if ($data=="1") {
			$this->response = "anda mengetikan satu";			
		} else {
			$this->response = "callback tidak dikenali!";
		}
	}
	
	function replyToSender() {
		if ($this->keyboard=="")
			$sendto = API_URL . "sendmessage?chat_id=" . $this->chatId . "&text=" . urlencode($this->response) . "&parse_mode=HTML";		
		else
			$sendto = API_URL . "sendmessage?chat_id=" . $this->chatId . "&text=" . urlencode($this->response) . "&parse_mode=HTML&reply_markup=" . urlencode($this->keyboard);
		logger($sendto);
		file_get_contents($sendto);
	}
	
	function processRequest() {
		if ($this->objType==MESSAGE)
			$this->processUserMessage();
		else
			$this->processUserCallback();
		$this->replyToSender();
	}
}

// Entry Point
try {
	$body = file_get_contents("php://input");
	if (strlen($body)>0) {
		$bot = new Bot($body);
		//check user berdasarkan $bot->getFormId()
		$bot->processRequest();
	}
	else
		echo "No payload";
} catch (Execption $e) {
	logger($e->getMessage());
}

//unit test
/*
$body = <<<EOD
{
	"update_id":250400716,
	"message":{
		"message_id":108,
		"from":{
			"id":568577002,
			"is_bot":null,
			"first_name":"Bob",
			"last_name":"Bob",
			"language_code":"en-us"
		},
		"chat": {
			"id":568577002,
			"first_name":"Bob",
			"last_name":"Bob",
			"type":"private"
		},
		"date":1538584262,
		"text":"/start"
	}
}
EOD;
$body=<<<EOD
{
    "update_id":250400717,
    "callback_query":{
        "id":2442019628980761722,
        "from":{
            "id":568577002,
            "is_bot":0,
            "first_name":"Bob",
            "last_name":"Bob",
            "language_code":"en-us"
        },
        "message":{
            "message_id":109,
            "from":{
                "id":465801377,
                "is_bot":1,
                "first_name":"Hendrasoewarnobot",
                "username":"Hendrasoewarnobot"
            },
            "chat":{
                "id":568577002,
                "first_name":"Bob",
                "last_name":"Bob",
                "type":"private"
            },
            "date":1538584264,
            "text":"Hello"
        },
        "chat_instance":2365774229782843677,
        "data":"1"
    }
}
EOD;
$bot = new Bot($body);
//check user berdasarkan $bot->getFormId()
$bot->processRequest();
*/
?>

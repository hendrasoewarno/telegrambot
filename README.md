# telegrambot
Pembuatan Telegrambot

ketik: @Botfather
pilih: /newbot

pilih bot name: Hendrasoewarnobot
pilih username: Hendrasoewarnobot

Anda diberi bot token, simpan bot token anda.

```
Done! Congratulations on your new bot. You will find it at t.me/Hendrasoewarnobot.
You can now add a description, about section and profile picture for your bot,
see /help for a list of commands. By the way, when you've finished creating your cool bot,
ping our Bot Support if you want a better username for it. Just make sure the bot is fully
operational before you do this.

Use this token to access the HTTP API:1863288706:AAGC0d01Gv0Ag55p7J65PHPOwgg********
Keep your token secure and store it safely, it can be used by anyone to control your bot.
For a description of the Bot API, see this page: https://core.telegram.org/bots/api
```

Siapkan URL dan endpoint yang akan dipanggil oleh bot
https://api.telegram.org/bot{bot_token}/setWebhook?url={your_server_url}

contoh

https://api.telegram.org/bot1863288706:AAGC0d01Gv0Ag55p7J65PHPOwgg*******/setWebhook?url=https://ec2-3-15-196-245.us-east-2.compute.amazonaws.com/Hendrasoewarnobot/webhook.php

atau 

curl -F "url=https://ec2-3-15-196-245.us-east-2.compute.amazonaws.com/Hendrasoewarnobot/webhook.php" -F "certificate=@/etc/ssl/myCerts/72576561_ec2-3-15-196-245.us-east-2.compute.amazonaws.com.pem" https://api.telegram.org/bot1863288706:AAGC0d01Gv0Ag55p7J65PHPOwgg********/setWebhook

Kalau anda menggunakan self-sign certificate

jika berhasil akan mendapat pesan

{"ok":true,"result":true,"description":"Webhook was set"}

coba cek sekali lagi
https://api.telegram.org/bot{bot_token}/getWebhookInfo

contoh

https://api.telegram.org/bot1863288706:AAGC0d01Gv0Ag55p7J65PHPOwgg********/getWebhookInfo

kemudian anda dapat juga menghapus webhook dengan perintah
https://api.telegram.org/bot{bot_token}/deleteWebhook

Pemrograman sisi endpoint webhook.php
Ketika seorang user mengetik /start
pada halaman bot anda, maka telegram akan mengirim ke endpoint

```
{

    "update_id":829256010,
    "message":{
        "message_id":37,
        "from":{
            "id":568577002,
            "is_bot":false,
            "first_name":"bob",
            "username":"bob",
            "language_code":"en"
        },
        "chat":{
            "id":568577002,
            "first_name":"bob",
            "username":"bob",
            "type":"private"
        },
        "date":1624110742,
        "text":"/start",
        "entities":[
            {
                "offset":0,
                "length":6,
                "type":"bot_command"
            }
        ]
    }

}
```

atau kalau callback

```
{
    "update_id":829256017,
    "callback_query":{
        "id":"2442019629950976978",
        "from":{
            "id":568577002,
            "is_bot":false,
            "first_name":"bob",
            "username":"bob",
            "language_code":"en"
        },
        "message":{
            "message_id":45,
            "from":{
                "id":1863288706,
                "is_bot":true,
                "first_name":"Hendrasoewarnobot",
                "username":"Hendrasoewarnobot"
            },
            "chat":{
                "id":568577002,
                "first_name":"bob",
                "username":"bob",
                "type":"private"
            },
            "date":1624110952,
            "text":"Selamat datang ke bot Hendrasoewarnobot",
            "reply_markup":{
                "inline_keyboard":[
                    [
                        {
                            "text":"\u270f Register",
                            "callback_data":"1"
                        },
                        {
                            "text":"\u2611 Verify Account",
                            "callback_data":"2"
                        }
                    ]
                ]
            }
        },
        "chat_instance":"-7133992681844504977",
        "data":"1"
    }

}

```

catatan:
message->chat->id: 568577002 atau call_back_query->message->chat->id: 568577002
merupakan id yang dapat kita gunakan untuk mengirim pesan kembali kepada user tersebut

https://api.telegram.org/bot{bot_token}/sendMessage?chat_id={chat_id}&text={text}

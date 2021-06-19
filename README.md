# Telegrambot
Create Telegrambot using WebHook Technique

## Create & Register PHP Endpoint

1. Open Telegram anda find @Botfather
2. Choose: /newbot
3. Enter your botname: Hendrasoewarnobot
4. Enter username: Hendrasoewarnobot
5. Telegram will issue secret HTTP API token (keep it secretly)

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
6. Prepare your URL and Endpoint that serve telegram bot, and register with telegram using web browser
```
https://api.telegram.org/bot{bot_token}/setWebhook?url={your_server_url}

example (for CA signed):

https://api.telegram.org/bot1863288706:AAGC0d01Gv0Ag55p7J65PHPOwgg*******/setWebhook?url=https://ec2-3-15-196-245.us-east-2.compute.amazonaws.com/Hendrasoewarnobot/webhook.php

or (for Self signed)

curl -F "url=https://ec2-3-15-196-245.us-east-2.compute.amazonaws.com/Hendrasoewarnobot/webhook.php" -F "certificate=@/etc/ssl/myCerts/72576561_ec2-3-15-196-245.us-east-2.compute.amazonaws.com.pem" https://api.telegram.org/bot1863288706:AAGC0d01Gv0Ag55p7J65PHPOwgg********/setWebhook
```
7. If succeed, than telegram will response
jika berhasil akan mendapat pesan
```
{"ok":true,"result":true,"description":"Webhook was set"}
```
8. Verify your registration result
```
https://api.telegram.org/bot{bot_token}/getWebhookInfo

example

https://api.telegram.org/bot1863288706:AAGC0d01Gv0Ag55p7J65PHPOwgg********/getWebhookInfo

{

    "ok":true,
    "result":{
        "url":"https://ec2-3-15-196-245.us-east-2.compute.amazonaws.com/Hendrasoewarnobot/webhook.php",
        "has_custom_certificate":true,
        "pending_update_count":0,
        "max_connections":40,
        "ip_address":"3.15.196.245"
    }

}
```

## End point preparation
In WeebHook approach, everytime user interact with your bot, than telegram will send payload to your bot with json format:
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
or callback format for keyboard

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

nb:
message->chat->id: 568577002 or call_back_query->message->chat->id: 568577002
is the id we will use to response to several user. We can send message or response
to user message using
```
https://api.telegram.org/bot{bot_token}/sendMessage?chat_id={chat_id}&text={text}

or

https://api.telegram.org/bot{bot_token}/sendMessage?chat_id={chat_id}&text={text}&parse_mode=HTML&reply_markup={keyboard}
```

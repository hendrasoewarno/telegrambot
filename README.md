# telegrambot
Pembuatan Telegrambot

ketik: @Botfather
pilih: /newbot

pilih bot name: Hendrasoewarnobot
pilih username: Hendrasoewarnobot

Anda diberi bot token, simpan bot token anda.

Siapkan URL dan endpoint yang akan dipanggil oleh bot
https://api.telegram.org/bot{bot_token}/setWebhook?url={your_server_url}

contoh

https://api.telegram.org/bot1863288706:AAGC0d01Gv0Ag55p7J65PHPOwggTRUmh7HY/setWebhook?url=https://ec2-3-15-196-245.us-east-2.compute.amazonaws.com/Hendrasoewarnobot/webhook.php

atau 

curl -F "url=https://ec2-3-15-196-245.us-east-2.compute.amazonaws.com/Hendrasoewarnobot/webhook.php" -F "certificate=@/etc/ssl/myCerts/72576561_ec2-3-15-196-245.us-east-2.compute.amazonaws.com.pem" https://api.telegram.org/bot1863288706:AAGC0d01Gv0Ag55p7J65PHPOwggTRUmh7HY/setWebhook

Kalau anda menggunakan self-sign certificate

jika berhasil akan mendapat pesan

{"ok":true,"result":true,"description":"Webhook was set"}

coba cek sekali lagi
https://api.telegram.org/bot{bot_token}/getWebhookInfo

contoh

https://api.telegram.org/bot1863288706:AAGC0d01Gv0Ag55p7J65PHPOwggTRUmh7HY/getWebhookInfo

kemudian anda dapat juga menghapus webhook dengan perintah
https://api.telegram.org/bot{bot_token}/deleteWebhook

Pemrograman sisi endpoint webhook.php
Ketika seorang user mengetik /start
pada halaman bot anda, maka telegram akan mengirim ke endpoint

{"message": {"chat": {"id": 457},"text": "/start uEDbtJFHxKc",}}

keterangan:
1. message.chat.id: 457
merupakan id yang dapat kita gunakan untuk mengirim pesan kembali kepada user tersebut

https://api.telegram.org/bot{bot_token}/sendMessage?chat_id={chat_id}&text={text}

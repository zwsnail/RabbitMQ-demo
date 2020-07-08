# RabbitMQ-demo

#### 1.Pull a docker image

`docker pull rabbitma:3-management`

`docker run -d --name YouName-of-rabbitmq -p 5672:5672 -p 15672:15672 -v /Users/me/Yourfolder/:/var/lib/rabbitmq rabbitmq:3-management
`

#####More info 🐳
https://registry.hub.docker.com/_/rabbitmq/?tab=description


#### 2.Install AMQPlib

`composer install`

#### 3.Connection

```$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest)```

>🆔 You could change or add the login name&password via the management-page:  **localhost:15672**

#### 4.How to use

Open more terminals to try each situation🎰
```
php fanout-sender.php
```
```
php fanout-worker1.php
```
```
php fanout-worker2.php
```


#### More detailed instructure follow my blog 🤓👇(Chinese)
https://www.jianshu.com/p/28141f380316

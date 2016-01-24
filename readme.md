# Example nette + crossbar async messaging

## Installation

 - Install [Crossbar](http://crossbar.io/docs/Quick-Start/)
 - `composer install`
 - `crossbar start`
 - `php -S localhost:8000 -t www`
 - [open that in browser](http://localhost:8000)


In this simple example we make ajax call to some heavy task.
This would be import or whatever.

From there we send notifications about the progress to specific client.

## Files

### .crossbar/config.json

here we specify ports and services listening on paths AND permissions.

I've configured this that websocket client has no permissions to publish,
 and only http publisher from local IP can publish (our PHP)

### app/services/Publisher

This class just sends requests to http publisher.
Here we could implement key/secure encryption before moving to production.

### app/providers/UserTopicProvider

this class provides us consistent user identifier.
We need our client (browser) to subscribe to this topic,
and our code to send messages to this topic.

This way we can target concrete user.
Targeting concrete browser window would need additional work.

 We would also subscribe our user to his role topic,
 so we can for example notify all readers about new blog post,
 but that is out of scope of this file (and this example)

### app/services/UserNotifier

This is our helper class, which defines two methods: notifyProgress and notifyMessage.

This defines structure for our JS code.

We could (should) create ProgressNotification and MessageNotification classes,
but this is enough for example.


### HomepagePresenter

Here we provide action, which sends topics to client.

Also, the core of this example is here - heavy action and usage of our classes.

### www/main.js

Here we connect to websocket server, get our topics and subscribe to them.

 Then, on message, we detect method (progress, message) and do something with them.


## Disclaimer

 This was example done in two hours including setting up project, installing dependencies and writing this doc.

 Code may look ugly here and there :]

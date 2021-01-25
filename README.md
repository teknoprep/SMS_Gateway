# SMS Gateway

# Features
- Developed on latest PHP frameowrk Codeigniter 4.0
- Send and Receive sms using Plivo or Twilio
- Add user and assign number from admin panel
- Real time chat using web socket

# Requirements
- PHP 7.0+
- PostgreSQL
- Port 8080 and 5555 for WebSocket

# Configuration
- Download sms gateway project using git clone --branch master https://github.com/teknoprep/SMS_Gateway.git .
- Import database using sms_gateway.sql into PostgreSQL
- After downloading go to code_app folder and run command "composer update", it will download all requires file into vendor folder.

# .env File Configuration
- Rename env file to .env located at code_app/env
- Open .env file and add domain url in app.baseURL = 'YOUR_DOMAIN_ULR' and add database configuration in database section

# Constants.php File Configuration
- File location: code_app/app/Config/Constants.php
- Update your vendor folder location in CONS_VENDOR variable
- Add your domain or ip in CONS_WEBSOCKET_DOMAIN_NAME_OR_IP variable without http or https
- Define email SMTP configuration into email configuration section.
- Once you're ready to use Plivo or Twilio you can add token and secret key into SMS API configuration.

# configuration.js File Configuration
- File location: assets/js/configuration.js
- var link = Add your domain with http or https protocol
- var websocketDomainName = Add your domain name for websocket configuration
- var webSocketProtocol = Add wss(SSL) or ws(Non SSL)

# Congrats you have completed all initial configuration. 

# Admin Panel Access
- Add your email, fullname and password into setup.php file located at code_app/app/Controllers/Server.php
- Bydefault password is admin
- After setting up all above configuration time to create your admin user by opening this linke YOUR_DOMAIN/setup in browser. 
- Once opening setup link, don't forget to DELETE Setup.php file.
- You can now login into admin panel using this link YOUR_DOMAIN/admin

# lake_telemetry
This website displays a graph of lake temperature over a period of time.

It is made with plain PHPv8.1.2 and plain JavaScript + chart.js.

It runs on Apache/2.4.52.

Default apache2 configuration is ok for this website.

Default password is 123.

##Installation##

1. sudo apt update && sudo apt upgrade -y

2. sudo apt install apache2 php8.1 git -y

3. cd /var/www/html

4. sudo git clone https://github.com/FilipFric/lake_telemetry

5. sudo mv lake_telemetry/* . && sudo rm -r lake_telemetry
  
6. sudo systemctl enable apache2

7. sudo systemctl start apache2

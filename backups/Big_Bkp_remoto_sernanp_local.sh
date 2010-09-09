#!/bin/bash
fecha=$(date +%Y%m%d_%H_%I_%S)

mysqldump -h 10.10.11.4  -u  bigchinux -pgiorgio2 sernanp > /home/big/bkps/sernanp_$fecha.sql 
 
mysql -u root -pslackwarez  sernanp <  /home/big/bkps/sernanp_$fecha.sql 

bzip2  /home/big/bkps/sernanp_$fecha.sql 
       


#!/bin/bash
fecha=$(date +%Y%m%d_%H_%I_%S)

    
mysqldump -h 10.10.11.4  -u  bigchinux -pgiorgio2 areaspro_dbsiganp1 > /home/big/bkps/areaspro_dbsiganp1_$fecha.sql 

mysql -u root -pslackwarez areaspro_dbsiganp1 < /home/big/bkps/areaspro_dbsiganp1_$fecha.sql 

bzip2  /home/big/bkps/areaspro_dbsiganp1_$fecha.sql 
       


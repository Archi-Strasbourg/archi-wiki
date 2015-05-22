#!/bin/bash
#if [[ $# == 3 ]]
if [[ $# == 4 ]]
then

#Remove log file
if [[ -f /tmp/deploy.log ]]
then
echo "Removing previous log file"
rm /tmp/deploy.log
fi

#Remove db dump
if [[ -f $3.sql ]]
then 
echo "Removing previous db dump"
rm $3.sql
else
echo "Dumping data"
echo "mysqldump -u $1 -p$2 $3 > /tmp/$3.sql"
mysqldump -u $1 -p$2 $3 > /tmp/$3.sql
echo "Copying data from $3 to $4"
# echo "mysql -u $1 -p$2 -e "CREATE DATABASE $4""
mysql -u $1 -p$2 -e "CREATE DATABASE $4"
#echo "mysqldump -u $1 -p$2 $3 | mysql -u $1 -p$2 $4"
mysqldump -u $1 -p$2 $3 | mysql -u $1 -p$2 $4
echo "mysqldump -u $1 -p$2 $3 | mysql -u $1 -p$2 $4"
fi

#Loop on all patches
echo "Initialize loop on all patches"
for i in `ls 1.{0,1,3,4,5,7,8}*.sql`
do
echo "Patch file : $i"
echo "[PATCH] : $i"
mysql -u $1 -p$2 $4 < $i 2> /tmp/deploy.log
#echo "mysql -u $1 -p$2 $4 < $i 2>> /tmp/deploy.log"
echo "[PATCH] : END OF $i"
done
else
echo "Nombre de paramètres incrorrect"
echo $0 login_sql pwd_sql db_name_src db_name_dest
fi


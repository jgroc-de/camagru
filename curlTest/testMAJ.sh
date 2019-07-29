#!/bin/bash

cp $1 tmp.sed
file="tmp.sed"
sed -ri "s|(pseudo=\")test|\1testRoot|" $file
sed -ri "s|(pass=\")Test00|\1testRoot0|" $file
sed -ri "$2,$5 s|^test.*=\"|    \\\"{|" $file
sed -ri "$2,$3 s|\{.*;&|{|" $file
sed -ri "$2,$3 s|;.{3}\"$|\\\"}\"|" $file
sed -ri "$2,$3 s|&|\\\",\\\"|g" $file
sed -ri "$2,$3 s|=|\\\":\\\"|g" $file
sed -ri "$2,$3 s|\{|{\\\"|g" $file
sed -ri '/\{/ s|"|\\"|2g' $file
sed -ri 's|\\"$|"|' $file

sed -ri "$4,$5 s|;.*;|;|" $file
sed -ri "$4,$5 s|login.*\"|login;200;POST\"|" $file
sed -ri "$4,$5 s|logout.*\"|login;200;DELETE\"|" $file
sed -ri "$4,$5 s|\{||" $file
sed -ri "$4,$5 s|401|400|" $file
cp $file $1
rm $file

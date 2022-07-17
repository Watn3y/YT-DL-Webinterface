##!/bin/bash
now=$(date)
size=$(du  files|cut -f1)
if [ $size -gt 20971520000 ] #check if there are more than 20GB in files
then
echo $now "   over LIMIT"
rm files/*
else
echo $now "   UNDER LIMIT"
fi

#this is intended to be run as a cronjob

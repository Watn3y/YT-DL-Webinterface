##!/bin/bash
size=$(du  files|cut -f1)
if [ $size -gt 20971520000 ] #check if there are more than 20GB in files
then
rm files/*
fi

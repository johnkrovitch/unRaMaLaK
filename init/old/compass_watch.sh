#!/bin/bash

cd web/sass
while true
do
  sleep 2
  compass compile -c config.rb
done
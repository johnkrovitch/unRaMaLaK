#!/bin/bash

cd web/sass
while true
do
  sleep 5
  compass compile -c config.rb
done
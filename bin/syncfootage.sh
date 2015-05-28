#!/bin/sh

workdir=/home/pi/petsy-cam/pir

# sync data and write log
sudo unison /media/usbdrv/footage /media/bb_PetsyCam01 -auto -silent -batch -terse -links=false -fat -confirmbigdel=false -log=true -logfile='/media/usbdrv/footage/logs/UnisonPetsyCam01.log' -ignore 'Name .*' -ignore 'Path logs/*'

# sync logfile
sudo unison /media/usbdrv/footage/logs /media/bb_PetsyCam01/logs -auto -silent -batch -terse -links=false -log=false -fat
#!/usr/bin/python
import RPi.GPIO as GPIO
import time
import requests
import socket

GPIO.setmode(GPIO.BCM)
TRIG = 13
ECHO = 19

print("Start test distance") # 수정
GPIO.setup(TRIG, GPIO.OUT)
GPIO.setup(ECHO, GPIO.IN)

try : 
	while True:
		GPIO.output(TRIG, False)
		time.sleep(0.5)
		
		GPIO.output(TRIG, True)
		time.sleep(0.5)
		
		GPIO.output(TRIG, False)
		while GPIO.input(ECHO) == 0 : 
			time_start = time.time() # 수정
		while GPIO.input(ECHO) == 1 : 
			time_end = time.time() # 수정
		time_duration = time_end - time_start # 수정
		roundtrip = time_duration * 34000 # 수정
		distance = round(roundtrip, 2)
		print("Distance: ", distance, "cm") # 수정
		
		url="http://localhost/iot/check.php?d={}".format(distance)
		requests.get(url)
except KeyboardInterrupt:
	pass
finally : 
	GPIO.output(TRIG, False)

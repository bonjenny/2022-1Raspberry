import RPi.GPIO as GPIO
import time
import requests
import socket

GPIO.setmode(GPIO.BCM)
TRIG = 13
ECHO = 19
GPIO.setup(TRIG, GPIO.OUT)
GPIO.setup(ECHO, GPIO.IN)
try :
    while True : 
        GPIO.output(TRIG, False)
        time.sleep(0.2)
        GPIO.output(TRIG, True)
        time.sleep(0.00001)
        GPIO.output(TRIG, False)
        while GPIO.input(ECHO) == 0 :
            time_start = time.time()
        while GPIO.input(ECHO) == 1 :
            time_end = time.time()
        time_duration = time_end - time_start
        roundtrip = time_duration * 34000
        distance = round(roundtrip, 2)
        if distance is not None:
            print(distance)
            url="http://localhost:8080/iot/check_time.php?"+"distance={}Cm".format(distance)
            requests.get(url)
        else:
            print("Failed to get reading.")
        time.sleep(3600)
except KeyboardInterrupt :
        pass
finally:
        GPIO.output(TRIG, False)
        GPIO.cleanup()

        

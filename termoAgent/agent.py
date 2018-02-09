import requests
import logging
import time
import Adafruit_DHT

###Set up logging
logger = logging.getLogger('Termo reader')
logger.setLevel(logging.INFO)

# create a file handler
handler = logging.FileHandler('/var/log/AM2302.log')
handler.setLevel(logging.INFO)

# create a logging format
formatter = logging.Formatter('%(asctime)s - %(name)s - %(levelname)s - %(message)s')
handler.setFormatter(formatter)

# add the handlers to the logger
logger.addHandler(handler)


###Set up sensor
sensor = Adafruit_DHT.AM2302
pin = 4

#read values
hValue, tValue = Adafruit_DHT.read_retry(sensor, pin)
logger.info('Reading data from sensor:%s, %s', hValue, tValue)

#Call API
headers = {'Content-type': 'application/json'}
API = "https://XXXX.XX/XXXX/dataCollector.php"
API_KEY = "secretCode"
data = { "auth" : API_KEY, "tValue": tValue, "hValue" : hValue }

r = requests.post(url = API, json = data, headers = headers)
logger.info('Response code from API: %s', r.status_code)

#the code I will implement will be similar to that logic
import requests
import io, json
import certifi
from xml.etree import ElementTree

HOSTNAME="YOUR_HOSTNAME"   # Namecheap hostname (including subdomain)
APIKEY="YOUR_DDNS_APIKEY"  # Namecheap DDNS Token (Accounts > Domain List > Advanced DNS)

def getIP():
	r = requests.get("https://ifconfig.co/json", verify=certifi.where()).json()
	return r['ip']

def updateRecord(ip):
	global HOSTNAME
	global APIKEY
	d = HOSTNAME.find('.')
	host = HOSTNAME[:d]
	domain = HOSTNAME[(d+1):]
	# DO NOT change the url "dynamicdns.park-your-domain.com". It's vaild domain provide by namecheap.
	return requests.get("https://dynamicdns.park-your-domain.com/update?host=" + host + "&domain=" + domain + "&password=" + APIKEY + "&ip=" + ip, verify=certifi.where())


ip = getIP()
print("External IP: " + ip)
r = updateRecord(ip)
errCount = ElementTree.fromstring(r.content).find("ErrCount").text
if int(errCount) > 0:
	print("API error\n" + r.content)
else:
	print("Updete IP success!")
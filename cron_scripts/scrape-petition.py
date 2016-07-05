import os, time, math

def floorStr(float_value):
  return str(int(math.floor(float_value)))

# many/some web hosts don't have pycurl... shove the ***ing thing in a file
def curlGetLines(url_to_get, temp_curl_filename):
  os.system('curl ' + curl_url + ' > ' + temp_curl_filename)

  myfile = open(temp_curl_filename)

  lines = []
  for line in myfile:
    lines.append(line)
  
  myfile.close()
  os.system("rm " + temp_curl_filename)
  
  return lines

temp_curl_filename = 'last_curl_response.txt'
curl_url = 'http://link.to.something/here'

response_lines = curlGetLines(curl_url, temp_curl_filename)

output = ''

for line in response_lines:
  if '<span>something</span>' in line:
    num_sigs = line.split(' ')[6]
    output += num_sigs

output += "|" + floorStr(time.time())

print output

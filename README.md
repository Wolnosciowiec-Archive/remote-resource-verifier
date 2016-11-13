# remote-resource-verifier
Microservice that takes URL addresses into a queue and performs checks

# Requirements
- PHP7
- Sqlite

# Paths

```
# put new item into the queue
GET /queue/add/{escapedUrlAddress}/{protocol eg. http, ftp}

# put multiple new items into the queue
POST /queue/add

Example POST data:

   - queue_data:
       0: 
           url_address: http://...
           type: image
       1:
           url_address: http://...
           type: url
           

# get all processed results and remove those elements from queue
GET /queue/flush

# internal job executed via HTTP-CRON (alternatively ./bin/console queue:process could be used from shell)
GET /jobs/process-queue
```

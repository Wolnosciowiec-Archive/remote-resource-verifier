# remote-resource-verifier
Microservice that takes URL addresses into a queue and performs checks

# Requirements
- PHP7
- Sqlite

# Paths

```
# put new items into the queue
/queue/add/{escapedUrlAddress}/{protocol eg. http, ftp}

# get all processed results and remove those elements from queue
/queue/flush

# internal job executed via HTTP-CRON (alternatively ./bin/console queue:process could be used from shell)
/jobs/process-queue
```

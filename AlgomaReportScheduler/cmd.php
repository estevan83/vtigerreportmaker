<?php

/*
cd public_html
clear && mysql -u cfg -h localhost -p'ZUOq8vRDblwZKn4' cfg -e "update algoma_reportscheduler set status =0, laststart = date_sub(now(5), interval 1 minute), lastend = now(5) where id =1;"
clear && mysql -u cfg -h localhost -p'ZUOq8vRDblwZKn4' cfg -e "update vtiger_cron_task set laststart=0, lastend = 0 where name = 'AlgomaReportScheduler'" && sh cron/vtigercron.sh

*/
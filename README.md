nbphp
=====
Netbackup PHP Report Tool

Provides a friendly access to netbackup common backup data, such as:
- Clients / Policys / Errors Lists
- Reports Utils
- Statistics Graphs
- Export options

## Requirements
- Apache/lighthttpd 
- Mysql Server
- Netbackup media server running under HP-UX / Linux
 
## Installation
### Web
- Configure according your web server in order to provide the correct url for the site
- Copy the content of the php directory into your new web server.
### Script
- See sql-generator/ directory

## Configuration
### Web
- Modify your src/config-db.php file with your database files
- Import the sql/tables.sql into your database
### Script
- See sql-generator/ directory

## Use
### Default Search option
- The system is configure with the following options by default
![alt tag](https://raw.githubusercontent.com/aledec/nbphp/master/git/images/default.png)
This options provides the following reports:
* Client 
 * Client List
 * Client List Type
 * Client List Graphics
* Policy 
 * Policy List
 * Policy Type Active/Inactive
 * Policy Hosts
 * Graphic Policy Type
 * Graphic Policy Active/Inactive
* Reports
 * Backup xx hs
 * Report order by time elapsed
 * Report order by kilobytes
 * Report order by average
 * Historic Consume
* Errors
 * List Errors
 * List Backups
 
### Examples
- Errors -> List Errors option
![alt tag](https://raw.githubusercontent.com/aledec/nbphp/master/git/images/error_list.png)
- Reports -> Historic Consume
![alt tag](https://raw.githubusercontent.com/aledec/nbphp/master/git/images/list_historic_consume.png)
- Policy -> Graphic Policy Type
![alt tag](https://raw.githubusercontent.com/aledec/nbphp/master/git/images/policy_type_graph.png)
- Reports -> Backup xx hs
![alt tag](https://raw.githubusercontent.com/aledec/nbphp/master/git/images/list_orderby_time.png)

#### Default Dashboard option
![alt tag](https://raw.githubusercontent.com/aledec/nbphp/master/git/images/default_dashboard.png)
If It is require to change dashboards available you can comment/uncomment/change time in the source code
```
<?php
 $e = new errors_FailedList_ds(); // List of return status not 0 - multiple params possible
  $params=array('name' => 'errors_FailedList_ds_7d', 'policy' => 'unix', 'timeago' => '7 Day', 3);
  $e->errors_FailedList_ds__data($params);
  $e->errors_FailedList_ds__table($params);
?>
```

#### Other Dashboard options
There're differents dashboards created for policy filter type, for example unix dashboard, which filter with "unix" string.
```
<?php
 $e = new errors_StatusLike_ds; // % of return status like code - multiple params possible
  $params=array('name' => 'errors_statuslike_ds_24h', 'policy' => 'unix', 'timeago' => '24 Hour', 3);
  $e->errors_StatusLike_ds__data($params);
  $e->errors_StatusLike_ds__graph($params);
?>
```
![alt tag](https://raw.githubusercontent.com/aledec/nbphp/master/git/images/dashboard_unix.png)


#  Synchronise System

we have two system . one is ours another is third party system and we want to keep the database structure which are in common , sync with each other.



## Examples

DB A (our system) `users` table has these fields :
```
`first_name` ,`last_name`,`phone` , `email`

```
DB B (third-party system) `users` table has these fields :
```
`full_name` ,`mobile_number` , `email`

```
in which the full_name is the concat of first_name and last_name
and mobile_number is phone with additional `0` in the beginning

these 2 system would be kept in sync with each other (for almost real time) based on Observer pattern and Event & Listener services
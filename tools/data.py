#!/usr/bin/python
import random
top = [
['root', 'tree', 'watt', 'watt', 'watt', 'watt'],
['tree', 'temperature', 'temperature', 'temperature', 'temperature', 'temperature', 'temperature'],
['tree', 'temperature', 'temperature', 'temperature', 'temperature', 'temperature', 'temperature'],
['tree', 'temperature', 'temperature', 'temperature', 'temperature', 'temperature'],
['tree', 'temperature', 'temperature', 'temperature', 'temperature', 'temperature'],
['tree', 'temperature', 'temperature', 'temperature', 'temperature'],
['tree', 'temperature', 'temperature', 'temperature', 'temperature'],
];



def catdata(LeafID, floor):
 #   for i in range():
     for i in range(7 * 24 * 60):
	status = 'regular'
	temp = random.randint(22, 26)
	abnormal = random.randint(0, 1000) 
	if (abnormal < 10):
		status = 'irregular'
		temp += 10
		#print "abnormal: %d" % temp
	#INSERT INTO `fju`.`Data` (`DateTime`, `TreeID`, `LeafID`, `data`, `Status`) VALUES (CURRENT_TIMESTAMP, '1', '1', '22.2', 'regular');
	q = "INSERT INTO `fju`.`Data` (`DateTime`, `TreeID`, `LeafID`, `data`, `Status`) VALUES (DATE_ADD(CURRENT_TIMESTAMP,INTERVAL %d MINUTE), '%d', '%d', %d, '%s');" % (i, floor, LeafID, temp, status)
	#if (status == 'abnormal'):
	print q




#INSERT INTO `fju`.`LeafID` (`LeafID`, `LeafDescription`, `Type`, `TreeID`, `Note`) VALUES ('1', '', 'root', '1', '');
floor = 1;
for n in top:
	LeafID = 1
	for i in n:
		q = "INSERT INTO `fju`.`LeafID` (`LeafID`, `LeafDescription`, `Type`, `TreeID`, `Note`) VALUES (%d, '', '%s', %d, '');" % (LeafID, i, floor)
		#print q
		catdata(floor, LeafID)
		LeafID += 1;
	floor += 1;
#sample: ./dump.py |mysql -u root  fju

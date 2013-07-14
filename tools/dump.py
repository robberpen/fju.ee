#!/usr/bin/python
top = [
['root', 'tree', 'watt', 'watt', 'watt', 'watt'],
['tree', 'temperature', 'temperature', 'temperature', 'temperature', 'temperature', 'temperature'],
['tree', 'temperature', 'temperature', 'temperature', 'temperature', 'temperature', 'temperature'],
['tree', 'temperature', 'temperature', 'temperature', 'temperature', 'temperature'],
['tree', 'temperature', 'temperature', 'temperature', 'temperature', 'temperature'],
['tree', 'temperature', 'temperature', 'temperature', 'temperature'],
['tree', 'temperature', 'temperature', 'temperature', 'temperature'],
];


#INSERT INTO `fju`.`LeafID` (`LeafID`, `LeafDescription`, `Type`, `TreeID`, `Note`) VALUES ('1', '', 'root', '1', '');
floor = 1
for n in top:
	LeafID = 1
	for i in n:
		q = "INSERT INTO `fju`.`LeafID` (`LeafID`, `LeafDescription`, `Type`, `TreeID`, `Note`) VALUES (%d, '', '%s', %d, '');" % (LeafID, i, floor)
		print q
		LeafID += 1;
	floor += 1;
#sample: ./dump.py |mysql -u root  fju

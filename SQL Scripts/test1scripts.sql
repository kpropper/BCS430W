/*5RS Create MySQL Script */

/*create and set database */
create database test1;

use test1;

/*create table scripts */

CREATE TABLE User (
UserID INT unsigned NOT NULL AUTO_INCREMENT,
FName varchar (150) NOT NULL,
LName varchar (150) NOT NULL,
Email varchar (150) NOT NULL,
Password varchar (150) NOT NULL,
Company_Name VARCHAR (150) Null,
Telephone varchar (25),
UserType varchar (10),
Value_Multiplier double Null,
PRIMARY KEY (UserID)
);

/*Did not auto increment the ID's since
this the ID's are already assigned in the
CSV files */

CREATE TABLE AssetCategory (
CategoryID INT unsigned NOT NULL AUTO_INCREMENT,
CategoryName varchar (75),
PRIMARY KEY (CategoryID)
);

CREATE TABLE Manufacturer (
ManufacturerID INT unsigned NOT NULL AUTO_INCREMENT,
ManufacturerName varchar (100),
PRIMARY KEY (ManufacturerID)
);

CREATE TABLE AssetModel (
ModelID INT unsigned NOT NULL AUTO_INCREMENT,
CategoryID INT NOT NULL,
ManufacturerID INT NOT NULL,
ModelName varchar (100) NOT NULL,
AssetModelValue double null,
PRIMARY KEY (ModelID),
FOREIGN KEY (CategoryID) REFERENCES AssetCategory(CategoryID),
FOREIGN KEY (ManufacturerID) REFERENCES Manufacturer(ManufacturerID)
);

CREATE TABLE Processor (
ProcessorID INT unsigned NOT NULL AUTO_INCREMENT,
ProcessorType varchar (50) NOT NULL,
ProcessorSpeed double NOT NULL,
ProcessorQty INT NOT NULL,
ProcessorValue double Null,
PRIMARY KEY (ProcessorID)
);


CREATE TABLE Memory (
MemoryID INT unsigned NOT NULL AUTO_INCREMENT,
MemoryType varchar (25) NOT NULL,
MemorySize varchar (10) NOT NULL,
MemoryQty INT NOT NULL,
MemoryValue double NULL,
PRIMARY KEY (MemoryID)
);

CREATE TABLE HardDrive (
HardDriveID INT unsigned NOT NULL AUTO_INCREMENT,
HardDriveType varchar (25) NOT NULL,
HardDriveSize varchar (25) NULL,
HardDriveQty INT NULL,
HardDriveValue double NULL,
PRIMARY KEY (HardDriveID)
);

CREATE TABLE Inventory (
InventoryID INT unsigned NOT NULL AUTO_INCREMENT,
UserID INT NOT NULL,
StatusID INT NULL,
Inventory_Value double Null,
InitQuoteMin double NULL,
InitQuoteMax double NULL,
FinalQuote double NULL,
PRIMARY KEY (InventoryID),
FOREIGN KEY (UserID) REFERENCES User(UserID),
FOREIGN KEY (StatusID) REFERENCES Status(StatusID)
);

CREATE TABLE Status (
StatusID INT unsigned NOT NULL AUTO_INCREMENT,
InventoryID INT NOT NULL,
StatusName varchar (50) not null,
StatusDate DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
QuoteValue double null,
StatusMessage varchar (500) null,
PRIMARY KEY (StatusID),
FOREIGN KEY (InventoryID) REFERENCES Inventory(InventoryID)
);

CREATE TABLE Asset (
AssetID INT unsigned NOT NULL AUTO_INCREMENT,
InventoryID INT NOT NULL,
ModelID INT NOT NULL,
HardDriveID INT NOT NULL,
ProcessorID INT NOT NULL,
MemoryID INT NOT NULL,
SerialNumber varchar (100) NULL,
ProductNumber varchar (100) NULL,
Quantity INT NULL,
CustomerConditionMod double null,
ActualConditionMiod double null,
AssetValue double NULL,
PRIMARY KEY (AssetID),
FOREIGN KEY (InventoryID) REFERENCES Inventory(InventoryID),
FOREIGN KEY (ModelID) REFERENCES AssetModel(ModelID),
FOREIGN KEY (HardDriveID) REFERENCES HardDrive(HardDriveID),
FOREIGN KEY (ProcessorID) REFERENCES Processor(ProcessorID),
FOREIGN KEY (MemoryID) REFERENCES Memory(MemoryID)
);

/*input data for the tables */

load data infile 'c:/wamp64/tmp/userdata.csv' into table user fields terminated by ',' lines terminated by '\r\n' ignore 1 lines;
load data infile 'c:/wamp64/tmp/categorydata.csv' into table AssetCategory fields terminated by ',' ignore 1 lines;
load data infile 'c:/wamp64/tmp/manufacturerdata.csv' into table Manufacturer fields terminated by ',' ignore 1 lines;
load data infile 'c:/wamp64/tmp/modeldata.csv' into table AssetModel fields terminated by ',' lines terminated by '\r\n' ignore 1 lines;
load data infile 'c:/wamp64/tmp/harddrivedata.csv' into table HardDrive fields terminated by ',' lines terminated by '\r\n' ignore 1 lines;
load data infile 'c:/wamp64/tmp/memorydata.csv' into table Memory fields terminated by ',' lines terminated by '\r\n' ignore 1 lines;
load data infile 'c:/wamp64/tmp/processordata.csv' into table Processor fields terminated by ',' lines terminated by '\r\n' ignore 1 lines;

/*Category Query for Dropdown
NOTE: Their selection should be stored as a PHP variable that
references categoryID */
select * from AssetCategory;

/* Manufacturer Query Based on Selection of Category
NOTE: Will need to change = 4 to the PHP stored variable
NOTE: The PHP variable needs to reference the categoryID */

select distinct ManufacturerName from manufacturer m
join assetmodel a on m.manufacturerid = a.manufacturerid
where a.categoryid = 4;

/*Model Query Based on Selection of Category and Manufacturer
NOTE: Will need to change = 4 and = 4 to the PHP stored variable
NOTE: PHP variables needs to reference the manufacturerID and the categoryID */

select distinct ModelName from assetmodel am
where am.manufacturerid = 4 and am.categoryid =4;

/*Part Number Query Based on Selection of Model
NOTE: Will need to change = "MacBookPro (5.4)" to the PHP stored variable
Note: PHP variable need to reference the ModelName choosen */

select distinct PartNumber from assetmodel am
where ModelName = "MacBookPro (5.4)";

/*Queries for Hard Drive Info*/

/*NOTE: Below query will be used for items that typically
have hard drives (i.e.- Laptops, Servers, Computers)

Note: Whatever selection is made by the user from
the drop down of selections generated by the below
query should be stored as a variable to be used later */

select DISTINCT HardDriveType from harddrive
where HardDriveType != "None" and HardDriveType != "N/A"
ORDER BY HardDriveType;

/*Note: Whatever selection is made by the user from
the drop down of selections generated by the below
query should be stored as a variable to be used later */

select DISTINCT HardDriveSize from harddrive;

/*Note: Whatever selection is made by the user from
the drop down of selections generated by the below
query should be stored as a variable to be used later */

select DISTINCT HardDriveQty from harddrive
ORDER BY HardDriveQty;

/*Note: Take the stored variables from above selections\
and plug them into the below query for HDD Type (SAS below),
HDD Size (1 TB below) and HDD Qty (1 below) */

select DISTINCT HardDriveID from harddrive
where HardDriveType = "SAS"
AND HardDriveSize = "1 TB"
AND HardDriveQty = 1;

/*Queries for Memory Info*/

/*NOTE: Below query will be used for items that typically
have memory (i.e.- Laptops, Servers, Computers)

Note: Whatever selection is made by the user from
the drop down of selections generated by the below
query should be stored as a variable to be used later */

select DISTINCT MemoryType from Memory
where MemoryType != "None" and MemoryType != "N/A";

/*Note: Whatever selection is made by the user from
the drop down of selections generated by the below
query should be stored as a variable to be used later */

select DISTINCT MemorySize from Memory
where MemorySize != "N/A";

/*Note: Whatever selection is made by the user from
the drop down of selections generated by the below
query should be stored as a variable to be used later */

select DISTINCT MemoryQty from Memory
ORDER BY MemoryQty;

/*Note: Take the stored variables from above selections\
and plug them into the below query for Memory Type (DDR4-3200 below),
MemorySize (8 GB below) and Memory Qty (4 below) */

select DISTINCT MemoryID from Memory
where MemoryType = "DDR4-3200"
AND MemorySize = "8 GB"
AND MemoryQty = 4;

/*Queries for Processor Info*/

/*NOTE: Below query will be used for items that typically
have processors (i.e.- Laptops, Servers, Computers)

Note: Whatever selection is made by the user from
the drop down of selections generated by the below
query should be stored as a variable to be used later */

select DISTINCT ProcessorType from Processor
where ProcessorType != "None" and ProcessorSpeed != "N/A"

/*Note: Whatever selection is made by the user from
the drop down of selections generated by the below
query should be stored as a variable to be used later */

select DISTINCT ProcessorSpeed from Processor
where ProcessorSpeed != 0;

/*Note: Whatever selection is made by the user from
the drop down of selections generated by the below
query should be stored as a variable to be used later */

select DISTINCT ProcessorQty from Processor
where ProcessorQty != 0
ORDER BY ProcessorQty;

/*Note: Take the stored variables from above selections\
and plug them into the below query for ProcessorType (i7-7560U below),
ProcessorSpeed (2.66 below) and ProcessorQty (2 below) */

select DISTINCT ProcessorID from Processor
where ProcessorType = "i7-7560U"
AND ProcessorSpeed = 2.66
AND ProcessorQty = 2;




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
PRIMARY KEY (UserID)
);

/*Did not auto increment the ID's since
this the ID's are already assigned in the
CSV files */

CREATE TABLE AssetCategory (
CategoryID INT NOT NULL,
CategoryName varchar (75),
PRIMARY KEY (CategoryID)
);

CREATE TABLE Manufacturer (
ManufacturerID INT NOT NULL,
ManufacturerName varchar (100),
PRIMARY KEY (ManufacturerID)
);

CREATE TABLE AssetModel (
ModelID INT NOT NULL,
CategoryID INT NOT NULL,
ManufacturerID INT NOT NULL,
ModelName varchar (100) NOT NULL,
PartNumber VARCHAR (100) NULL,
PRIMARY KEY (ModelID),
FOREIGN KEY (CategoryID) REFERENCES AssetCategory(CategoryID),
FOREIGN KEY (ManufacturerID) REFERENCES Manufacturer(ManufacturerID)
);

CREATE TABLE Processor (
ProcessorID INT NOT NULL,
ProcessorType varchar (50) NOT NULL,
ProcessorSpeed double NOT NULL,
ProcessorQty INT NOT NULL,
PRIMARY KEY (ProcessorID)
);


CREATE TABLE Memory (
MemoryID INT NOT NULL,
MemoryType varchar (25) NOT NULL,
MemorySize varchar (10) NOT NULL,
MemoryQty INT NOT NULL,
PRIMARY KEY (MemoryID)
);

CREATE TABLE HardDrive (
HardDriveID INT NOT NULL,
HardDriveType varchar (25) NOT NULL,
HardDriveSize varchar (25) NULL,
HardDriveQty INT NULL,
PRIMARY KEY (HardDriveID)
);

CREATE TABLE Asset (
AssetID INT NOT NULL,
UserID INT NOT NULL,
ModelID INT NOT NULL,
HardDriveID INT NOT NULL,
ProcessorID INT NOT NULL,
MemoryID INT NOT NULL,
InventoryID INT NOT NULL,
SerialNumber varchar (100) NULL,
ProductNumber varchar (100) NULL,
Quantity INT NOT NULL,
PRIMARY KEY (AssetID),
FOREIGN KEY (UserID) REFERENCES User(UserID),
FOREIGN KEY (ModelID) REFERENCES AssetModel(ModelID),
FOREIGN KEY (HardDriveID) REFERENCES HardDrive(HardDriveID),
FOREIGN KEY (ProcessorID) REFERENCES Processor(ProcessorID),
FOREIGN KEY (MemoryID) REFERENCES Memory(MemoryID),
FOREIGN KEY (InventoryID) REFERENCES Inventory(InventoryID)
);

CREATE TABLE Inventory (
InventoryID INT unsigned NOT NULL AUTO_INCREMENT,
UserID INT NOT NULL,
PRIMARY KEY (InventoryID, UserID),
FOREIGN KEY (UserID) REFERENCES User(UserID)
);

/*input data for the tables */

load data infile 'c:/wamp64/tmp/userdata.csv' into table user fields terminated by ',' ignore 1 lines;
load data infile 'c:/wamp64/tmp/categorydata.csv' into table AssetCategory fields terminated by ',' ignore 1 lines;
load data infile 'c:/wamp64/tmp/manufacturerdata.csv' into table Manufacturer fields terminated by ',' ignore 1 lines;
load data infile 'c:/wamp64/tmp/modeldata.csv' into table AssetModel fields terminated by ',' ignore 1 lines;
load data infile 'c:/wamp64/tmp/harddrivedata.csv' into table HardDrive fields terminated by ',' ignore 1 lines;

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

select DISTINCT HardDriveSize from harddrive
ORDER BY HardDriveSize;

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

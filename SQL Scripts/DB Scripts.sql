create database test1;

use test1;

CREATE TABLE User (
UserID INT unsigned NOT NULL AUTO_INCREMENT,
FName varchar (150) NOT NULL,
LName varchar (150) NOT NULL,
Email varchar (150) NOT NULL,
Password varchar (150) NOT NULL,
Company_Name VARCHAR (150) Null,
Telephone varchar (25),
PRIMARY KEY (UserID)
);

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
PartNumber VARCHAR (100) NULL,
PRIMARY KEY (ModelID),
FOREIGN KEY (CategoryID) REFERENCES AssetCategory(CategoryID),
FOREIGN KEY (ManufacturerID) REFERENCES Manufacturer(ManufacturerID)
);

CREATE TABLE Processor (
ProcessorID INT unsigned NOT NULL AUTO_INCREMENT,
ProcessorType varchar (50) NOT NULL,
ProcessorSpeed double NOT NULL,
ProcessorQty INT NOT NULL,
PRIMARY KEY (ProcessorID)
);


CREATE TABLE Memory (
MemoryID INT unsigned NOT NULL AUTO_INCREMENT,
MemoryType varchar (25) NOT NULL,
MemorySize varchar (10) NOT NULL,
MemoryQty INT NOT NULL,
PRIMARY KEY (MemoryID)
);

CREATE TABLE HardDrive (
HardDriveID INT unsigned NOT NULL AUTO_INCREMENT,
HardDriveType varchar (25) NOT NULL,
HardDriveSize varchar (25) NOT NULL,
HardDriveQty INT NOT NULL,
PRIMARY KEY (HardDriveID)
);

CREATE TABLE Asset (
AssetID INT unsigned NOT NULL AUTO_INCREMENT,
UserID INT NOT NULL,
ModelID INT NOT NULL,
HardDriveID INT NOT NULL,
ProcessorID INT NOT NULL,
MemoryID INT NOT NULL,
SerialNumber varchar (100) NULL,
ProductNumber varchar (100) NULL,
Quantity INT NOT NULL,
PRIMARY KEY (AssetID),
FOREIGN KEY (UserID) REFERENCES User(UserID),
FOREIGN KEY (ModelID) REFERENCES AssetModel(ModelID),
FOREIGN KEY (HardDriveID) REFERENCES HardDrive(HardDriveID),
FOREIGN KEY (ProcessorID) REFERENCES Processor(ProcessorID),
FOREIGN KEY (MemoryID) REFERENCES Memory(MemoryID)
);

CREATE TABLE Inventory (
InventoryID INT unsigned NOT NULL AUTO_INCREMENT,
UserID INT NOT NULL,
AssetID INT NOT NULL,
PRIMARY KEY (InventoryID, UserID, AssetID),
FOREIGN KEY (UserID) REFERENCES User(UserID),
FOREIGN KEY (AssetID) REFERENCES Asset(AssetID)
);


load data infile 'c:/wamp64/tmp/userdata.csv' into table user fields terminated by ',' ignore 1 lines;
load data infile 'c:/wamp64/tmp/categorydata.csv' into table AssetCategory fields terminated by ',' ignore 1 lines;
load data infile 'c:/wamp64/tmp/manufacturerdata.csv' into table Manufacturer fields terminated by ',' ignore 1 lines;
load data infile 'c:/wamp64/tmp/modeldata.csv' into table AssetModel fields terminated by ',' ignore 1 lines;

CREATE TABLE Passwords (
  	PasswordID int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  	CurrentPassword varchar(255),
	PreviousPassword varchar(255),
	LastChangedDate DATE,
	ExpiryDate DATE,
	SecurityQuestion varchar(255),
	SecurityAnswer varchar(255),
	Strikes int
);
CREATE TABLE Users (
    	UserID int PRIMARY KEY NOT NULL AUTO_INCREMENT,
    	UserName varchar(255),
    	FirstName varchar(255),
    	LastName varchar(255),
	UserType int,
   	EmailAddress varchar(255),
    	BirthDate DATE,
	PasswordID int,
    	FOREIGN KEY (PasswordID) REFERENCES Passwords(PasswordID)    
); 
CREATE TABLE Accounts (
    	AccountNumber int PRIMARY KEY NOT NULL,
    	AccountName varchar(255),
    	Description varchar(2555),
    	NormalSide enum('left','right'),
	Category varchar(255),
	SubCategory varchar(255)
	InitialBalance double,
	Debit double,
	Credit double,
	CurrentBalance double,
	DateAdded DATE,
   	CreatorID int,  
	AccountOrder int,
	AccountStatement varchar(255),
	Comment varchar(2555)
	);
	
CREATE TABLE Messages
	UserID int PRIMARY KEY NOT NULL, 
	UserID2 int PRIMARY KEY NOT NULL, 
	User1 int (20) NOT NULL,
   	User2 int (20) NOT NULL
    	Tittle varchar(255),
    	Message text NOT NULL,
    	Timestamp int NOT NULL,
	User1read varchar(3) NOT NULL,
   	User2read varchar (3) NOT NULL
	  	

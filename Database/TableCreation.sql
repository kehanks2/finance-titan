
CREATE TABLE Passwords (
  	PasswordID int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  	CurrentPassword varchar(255),
	PreviousPassword varchar(255),
	LastChangedDate DATE,
	ExpiryDate DATE,
	SecurityQuestion varchar(255),
	SecurityAnswer varchar(255)
);
CREATE TABLE Users (
    	UserID int PRIMARY KEY NOT NULL AUTO_INCREMENT,
    	UserName varchar(255),
    	FirstName varchar(255),
    	LastName varchar(255),
   	EmailAddress varchar(255),
    	BirthDate DATE,
	PasswordID int,
    	FOREIGN KEY (PasswordID) REFERENCES Passwords(PasswordID)    
); 

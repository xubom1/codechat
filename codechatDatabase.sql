CREATE TABLE user(
    id INT AUTO_INCREMENT PRIMARY KEY,
    pseudo VARCHAR(50) NOT NULL,
    mail VARCHAR(50) NOT NULL,
    lastName VARCHAR(50),
    firstName VARCHAR(50),
    grade INT2 NOT NULL DEFAULT 0,
    subscription INT2 NOT NULL DEFAULT 0,
    postalCode CHAR(5),
    city VARCHAR(50),
    address VARCHAR(50),
    password VARCHAR(255),
    banned boolean NOT NULL DEFAULT 0,
    admin boolean NOT NULL DEFAULT 0,
    wantNews boolean NOT NULL DEFAULT 1,
    creation DATETIME NOT NULL DEFAULT NOW(),
    lastLogin DATETIME NOT NULL DEFAULT NOW()
);

CREATE TABLE publication(
    id INT AUTO_INCREMENT PRIMARY KEY,
    content TEXT,
    lastEdition DATETIME NOT NULL DEFAULT NOW(),
    respondTo INT,
    creator INT NOT NULL,
    FOREIGN KEY(respondTo) REFERENCES publication(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(creator) REFERENCES user(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE image(
    id INT AUTO_INCREMENT PRIMARY KEY,
    path VARCHAR(255) NOT NULL,
    publication INT NOT NULL,
    FOREIGN KEY (publication) REFERENCES publication(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE liked(
    publication INT,
    user INT,
    PRIMARY KEY (publication, user),
    FOREIGN KEY (user) REFERENCES user(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (publication) REFERENCES publication(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE follow(
    follower INT,
    followed INT,
    PRIMARY KEY (followed, follower),
    FOREIGN KEY(follower) REFERENCES user(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(followed) REFERENCES user(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE avatarcomponent(
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    path VARCHAR(50) NOT NULL,
    type INT
);

CREATE TABLE avatarownership(
       owner INT,
       component INT,
       PRIMARY KEY(owner, component),
       FOREIGN KEY(owner) REFERENCES user(id),
       FOREIGN KEY(component) REFERENCES avatarcomponent(id)
);

CREATE TABLE events (   
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,   
    name VARCHAR(100),  
    description VARCHAR(255),  
    starting_date DATETIME,   
    ending_date DATETIME,   
    location VARCHAR(100),   
    user INT,   
    FOREIGN KEY (user) REFERENCES user(id) 
);

CREATE TABLE eventSign (
    signer VARCHAR(80) REFERENCES user(id),
    event VARCHAR(80) REFERENCES events(id),
    PRIMARY KEY (signer, event)
);

CREATE TABLE message(
    id INT AUTO_INCREMENT PRIMARY KEY,
    author INT REFERENCES user(id),
    receiver INT REFERENCES user(id),
    content VARCHAR(255) NOT NULL,
    creation DATETIME NOT NULL DEFAULT NOW()
);
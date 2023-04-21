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

CREATE TABLE message(
    author INT REFERENCES user(id),
    receiver INT REFERENCES user(id),
    content VARCHAR(255) NOT NULL,
    creation DATETIME NOT NULL DEFAULT NOW()
);

CREATE TABLE newsletter (
    id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    title TEXT,
    content TEXT,
    creationDateTime DATETIME,
    sendDateTime DATETIME,
    deleted BOOLEAN DEFAULT 0,
    createBy VARCHAR(50),
    sent BOOLEAN DEFAULT 0,
    sendTo VARCHAR(18)
);

CREATE TABLE sendTo (
    id_newsletter INT,
    id_user INT,
    PRIMARY KEY (id_newsletter, id_user),
    FOREIGN KEY(id_newsletter) REFERENCES newsletter(id),
    FOREIGN KEY(id_user) REFERENCES user(id)
);

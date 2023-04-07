#heads
INSERT INTO avatarcomponent(name, path, type) VALUES('white head','assets/avatars/whiteHead.png', 1);
INSERT INTO avatarcomponent(name, path, type) VALUES('black head','assets/avatars/blackHead.png', 1);

#hairs
INSERT INTO avatarcomponent(name, path, type) VALUES('black hair','assets/avatars/blackHair.png', 2);
INSERT INTO avatarcomponent(name, path, type) VALUES('blond hair','assets/avatars/blondHair.png', 2);
INSERT INTO avatarcomponent(name, path, type) VALUES('blue hair','assets/avatars/blueHair.png', 2);
INSERT INTO avatarcomponent(name, path, type) VALUES('red hair','assets/avatars/redHair.png', 2);

DELETE avatarownership FROM avatarownership CROSS JOIN avatarcomponent ON avatarownership.component = avatarcomponent.id WHERE avatarownership.owner = 101 AND avatarcomponent.type = 2;


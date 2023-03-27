import db
import csv
import random
import sys

def generateUsers(number):
    file = open('./data/users.csv', encoding='utf-8')
    users = list(csv.reader(file))
    userCounter = 0
    while userCounter < number:
        u = users[random.randint(0, len(users) - 1)]
        name = u[2].split(' ')
        i = 0
        while not db.user(u[0], u[1], name[1], name[0], random.randint(10000, 99999), u[4], u[5], '$2y$10$XcMljkfAj9l8jmTcOAV2oOxkA2gclErOddIjMb75TcMQODzDtglA.', random.randint(0, 3), random.randint(0, 1)): 
            suffix = str(random.randint(0, 9))
            u[0] += suffix
            pos = u[1].find('@')
            u[1] = u[1][:pos] + suffix + u[1][pos:]
            if (i > 8):
                userCounter -= 1
                break
            i += 1
        userCounter += 1
        if (userCounter % 100 == 0): print(userCounter, " users were created...")
    print("done !")
    file.close()

def generateFollows(number):
    userCount = db.userCount()
    follow = 0
    while follow < number:
        a = random.randint(1, userCount)
        b = random.randint(1, userCount)
        while b == a: b = random.randint(1, userCount)
        if (db.follow(db.userAtIndex(a)[0], db.userAtIndex(b)[0])):
            follow += 1
        if (follow % 100 == 0): print(follow, " follow were created...")
    print("done !")

def generatePublications(number):
    file = open("./data/content.txt", "r", encoding='utf-8')
    content = file.read()
    size = len(content)
    userCount = db.userCount()

    publicationCount = 0
    while publicationCount < number:
        start = content.find('.', random.randint(0, size - 2000)) + 1
        end = content.find('.',start + random.randint(50, 1000)) + 1

        if db.publish(db.userAtIndex(random.randint(1, userCount))[0], content[start:end]):
            publicationCount += 1
        if(publicationCount % 100 == 0): print(publicationCount, " publications were created...")
    print("done !")

def generateComments(number):
    userCount = db.userCount()
    existingCommentsCount = db.publicationCount()
    CommentCount = 0
    comments = ["Trop vrai !", "Completement faux !", "j'adore rire !", "vive la vie !", "la guerre c'est mal, la paix c'est bien.", "c'est pas gentil d'être méchant", "first", "bonne anniversaire"]
    while CommentCount < number:
        comment = comments[random.randint(0, len(comments) - 1)]
        if db.publish(db.userAtIndex(random.randint(1, userCount))[0], comment, db.publicationAtIndex(random.randint(1, existingCommentsCount))[0]):
            CommentCount += 1

        if(CommentCount % 100 == 0): 
            print(CommentCount, " comments were created...")

    print("done !")

def generateLikes(number):
    userCount = db.userCount()
    CommentsCount = db.publicationCount()
    likesCount = 0

    while likesCount < number:
        if db.like(db.userAtIndex(random.randint(1, userCount))[0], db.publicationAtIndex(random.randint(1, CommentsCount))[0]):
            likesCount += 1

        if(likesCount % 100 == 0): 
            print(likesCount, " likes were created...")

    print("done !")


#cmd
def addCommand(arg: str, function):
    if len(sys.argv) >= 3 and sys.argv[1] == '-' + arg:
        function(int(sys.argv[2]))

addCommand("user", generateUsers)
addCommand("follow", generateFollows)
addCommand("publication", generatePublications)
addCommand("comment", generateComments)
addCommand("like", generateLikes)
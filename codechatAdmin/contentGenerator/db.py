#coding=utf-8
import pymysql

# connect to the database :
try:
    db = pymysql.connect(
        host='localhost',
        user='root',
        password='esgi',
        database='codechat'
    )
except:
    print("failed to connect to the database !")
    exit()


def userExists(pseudo: str) -> bool:
    with db.cursor() as cursor:
        cursor.execute("SELECT EXISTS(SELECT pseudo FROM user WHERE pseudo=%s);", (pseudo))
        return bool(cursor.fetchone()[0])
    
def userCount() -> int:
    with db.cursor() as cursor:
        cursor.execute("SELECT COUNT(*) FROM user")
        return int(cursor.fetchone()[0])

def userAtIndex(rowNumber) -> tuple:
    with db.cursor() as cursor:
        cursor.execute("SELECT * FROM user LIMIT %s, 1", (rowNumber - 1))
        return cursor.fetchone()


def user(pseudo :str, mail: str, lastName: str, firstName: str, postalCode: int, city: str, address: str, password: str, grade = 0, subscription = 0, banned = 0, admin = 0) -> bool: 
    if userExists(pseudo):
        return False
    
    query = "INSERT INTO user(pseudo, mail, lastName, firstName, postalCode, city, address, password, grade, subscription, banned, admin) VALUES(%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s);"

    try:
        with db.cursor() as cursor:
            data = (pseudo, mail, lastName, firstName, postalCode, city, address, password, grade, subscription, banned, admin)
            cursor.execute(query, data)
    except:
        return False

    db.commit()
    return True

def follow(follower: int, followed: int) -> bool:
    query = "INSERT INTO follow (follower, followed) VALUES(%s,%s)"

    try:
        with db.cursor() as cursor:
            data = (follower, followed)
            cursor.execute(query, data)
    except:
        return False
    
    db.commit()
    return True
    
def publish(creator, content, respondTo = None) -> bool:
    if(respondTo):
        query = "INSERT INTO publication (creator, content, respondTo) VALUES(%s, %s, %s)"
        data = (creator, content, respondTo)
    else:
        query = "INSERT INTO publication (creator, content) VALUES(%s, %s)"
        data = (creator, content)

    try:
        with db.cursor() as cursor:
            cursor.execute(query, data)
    except:
        return False
    
    db.commit()
    return True

def publicationCount() -> int:
    with db.cursor() as cursor:
        cursor.execute("SELECT COUNT(*) FROM publication")
        return int(cursor.fetchone()[0])
    
def publicationAtIndex(rowNumber) -> int:
    with db.cursor() as cursor:
        cursor.execute("SELECT * FROM publication LIMIT %s, 1", (rowNumber - 1))
        return cursor.fetchone()
    
def like(user, publication):
    query = "INSERT INTO liked (user, publication) VALUES(%s,%s)"

    try:
        with db.cursor() as cursor:
            data = (user, publication)
            cursor.execute(query, data)
    except:
        return False
    
    db.commit()
    return True

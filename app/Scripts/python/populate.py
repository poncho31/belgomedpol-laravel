#!/usr/bin/env python
# encoding: utf-8

try:
    import os
    import sys
    import psutil
    import subprocess
    import pipes

    import idna
    import requests
    from ftplib import FTP
    import pysftp

    from bs4 import BeautifulSoup
    import feedparser
    import configparser
    import re

    import MySQLdb
    import mysql.connector
    from htmldom import htmldom

    import time
    from datetime import datetime, timedelta
    from email.utils import parsedate_tz, mktime_tz
    
    from Data import *
except ImportError as error:
    # If import error then install missing package
    open("./rssLogs.log", "a+", encoding="utf-8").write("Import error : "+ error.name + " not found \n")
    from pip._internal import main as pipmain
    pipmain(['install', error.name])
    open("./rssLogs.log", "a+", encoding="utf-8").write("Imported : "+ error.name + "\n")
    # Restart programm
    open("./rssLogs.log", "a+", encoding="utf-8").write("Restart \n")
    try:
        p = psutil.Process(os.getpid())
        for handler in p.open_files() + p.connections():
            os.close(handler.fd)
    except Exception as e:
        open("./rssLogs.log", "a+", encoding="utf-8").write("Import fatal error :"+ str(e) + "\n")
        exit()
    python = sys.executable
    os.execl(python, python, *sys.argv)

# FUNCTIONS
def restart_program():
    """Restarts the current program, with file objects and descriptors
    cleanup
    """
    try:
        p = psutil.Process(os.getpid())
        for handler in p.open_files() + p.connections():
            os.close(handler.fd)
    except Exception as e:
        open("./rssLogs.log", "a+", encoding="utf-8").write("Import fatal error :"+ str(e) + "\n")
        exit()
    python = sys.executable
    os.execl(python, python, *sys.argv)

def parse(content):
    return BeautifulSoup(content, "html.parser").text.replace('\n', '').strip().replace('(Belga)', '').replace("“", '"').replace("”", '"').replace("«", '"').replace("»", '"').replace("[","").replace("]","").strip()

def formatDate(date):
    timestamp = timestamp = mktime_tz(parsedate_tz(date))
    utc_time = datetime(1970, 1, 1) + timedelta(seconds=timestamp)
    return str(utc_time.strftime("%Y-%m-%d"))

def mysqlConnect():
    return mysql.connector.connect(
            host=config("Database","host"),
            user=config("Database","login"),
            password=config("Database","pass"),
            database=config("Database","dbname")
           )

def insertDDB(val):
    mydb = mysqlConnect()
    mycursor = mydb.cursor()
    sql = "INSERT INTO media (nom, titre, description, date, lien, article) VALUES (%s, %s, %s, %s, %s, %s)"
    insert = (val[0], val[1], val[2], val[3], val[4], val[5])
    mycursor.execute(sql, insert)
    mydb.commit()
    # mycursor.close()

def selectDDB(date, link):
    mydb = mysqlConnect()
    mycursor = mydb.cursor()
    sql = "SELECT lien FROM (SELECT * FROM media WHERE date = %s) sub WHERE lien = %s ORDER BY idMedia DESC LIMIT 1"
    select = (date, link)
    mycursor.execute(sql, select)
    return mycursor.fetchone()

def getMedia(link):
    if "lesoir" in link: return "lesoir"
    elif "dhnet" in link: return "dh"
    elif "lalibre" in link: return "lalibre"
    elif "feedburner" in link: return "rtl"
    elif "feedproxy" in link: return "rtl"
    elif "lecho" in link: return "lecho"
    elif "levif" in link: return "levif"
    elif "rtbf" in link: return "rtbf"
    elif "sudinfo" in link: return "sudinfo"
    else: return link

def getTag(media, increment = 0):
    try:
        # print(media)
        tags = {
                "sudinfo" : [".gr-article-content"],
                "rtbf": [".rtbf-paragraph"],
                "rtl": [".w-content-details-article-body","#body-detail"],
                "dh":[".article-text",".articleText"],
                "lalibre": [".article-text",".articleText"],
                "lecho": [".ac_paragraph"],
                "lesoir": [".gr-article-content"],
                "levif": ["#article-body"]
        }
        
        # print(tags[media][0])
        typeTag = "id" if "#" in tags[media][0] else "class"
        # print(typeTag)
        return {typeTag:tags[media][increment][1:]}
    except Exception as e:
        print(e)
        

def parseTags(content):
    dom = BeautifulSoup(content, 'html5lib')
    [x.extract() for x in dom.findAll('script')]
    targetA = dom.find("a", {"class":"article-sectionLink"})
    target = content.replace(str(targetA.text), "") if targetA else dom
    return target

def log(text, file):
    file.write(text + "\n")

def getContent(link):
    return (requests.get(link)).text

def dbBackup(mysqldump = 1):
    DB_HOST = 'localhost' 
    DB_USER = 'root'
    DB_PASS = ''
    DB_NAME = 'rss'
    if(mysqldump):
        # Getting current DateTime to create the separate backup folder like "20180817-123433".
        path = "BACKUP_rss"
        print ("Starting backup of database " + DB_NAME)
        # + " -p" + DB_USER_PASSWORD
        dumpcmd = "mysqldump -h " + DB_HOST + " -u " + DB_USER  + " " + DB_NAME + " > " + pipes.quote(path) + ".sql"
        try:
            os.system(dumpcmd)
            gzipcmd = "gzip -f " + pipes.quote(path) + ".sql"
            os.system(gzipcmd)
            log("Backup database             : OK" , f)
        except OSError:
            log("Backup database             : WRONG command" , f)

    else:
        con = MySQLdb.connect(host=DB_HOST, user=DB_USER, passwd=DB_PASS, db=DB_NAME)
        cur = con.cursor()

        cur.execute("SHOW TABLES")
        data = ""
        tables = []
        for table in cur.fetchall():
            tables.append(table[0])

        for table in tables:
            data += "DROP TABLE IF EXISTS `" + str(table) + "`;"

            cur.execute("SHOW CREATE TABLE `" + str(table) + "`;")
            data += "\n" + str(cur.fetchone()[1]) + ";\n\n"

            cur.execute("SELECT * FROM `" + str(table) + "`;")
            for row in cur.fetchall():
                data += "INSERT INTO `" + str(table) + "` VALUES("
                first = True
                for field in row:
                    if not first:
                        data += ', '
                    data += '"' + str(field) + '"'
                    first = False


                data += ");\n"
            data += "\n\n"

        now = datetime.now()
        # + now.strftime("%Y-%m-%d_%H:%M")
        filename = "backup_"  + ".sql"

        FILE = open(filename,"w")
        FILE.writelines(str(data.encode("utf-8")))
        FILE.close()

pass #end dbBackup

def config(section, value):
    config = configparser.ConfigParser()
    config.read("config.ini")
    return config.get(section, value)
pass

def sendFTP(filepath, filename = "BackupRssDB.sql.gz"):
    with pysftp.Connection(host=config("FTP","host"), username=config("FTP","login"), password=config("FTP","pass")) as sftp:
        try:
            sftp.put(filepath, '../httpd.private/FTP/'+filename)
            log("FTP    database             : OK" , f)
        except:
            log("FTP    database             : ERROR" , f)
pass


# PROGRAM
# -------------------PROGRAM : RETRIEVE RSS FEED -----------------
start = time.time()
f=open("./rssLogs.log", "a+", encoding="utf-8")
newArticles = 0
alreadyInDB = 0
# count = 1
# dbBackup()
# sendFTP("BACKUP_rss.sql.gz")

for feed in feeds:

    # print(str(count) + "/" + str(len(feeds)) + " : " + feed)
    # count+=1
    rssContent = feedparser.parse(feed).entries
    for content in rssContent:
        
        link = content.link
        title = parse(content.title)
        description = parse(content.summary)
        date = formatDate(content.published)
        media = getMedia(link)

        # Check if in DDB
        isInDDB = selectDDB(date, link)
        # isInDDB = False
        if isInDDB:
            alreadyInDB += 1
        else:
            # -----RETRIEVE FULL ARTICLE FROM URL --
            parseTag = parseTags(getContent(link))
            # parseTag = parseTags(getContent("https://www.lalibre.be/dernieres-depeches/afp/joe-biden-lance-sa-campagne-dans-un-vieux-bastion-ouvrier-de-pennsylvanie-5cc69d829978e25347c29ca1"))
            dom = BeautifulSoup(str(parseTag), 'html5lib')
            # log(str(getTag(media)), f)
            log(str(link), f)

            # Va chercher class/id si ne trouve rien teste second élément du tableau
            findArt = dom.find_all("div",getTag(media)) 
            if findArt:
                findart = findArt[0]
                # print("0  => " + str(getTag(media, 0)))
                # print(findArt[0])
            else:
                findArt = dom.find_all("div",getTag(media, 1))
                findArt = findArt[0] if findArt else ""
                # print("1  =>  " + str(getTag(media, 1)))
                # print(findArt)
                pass

            article = ""
            if findArt:
                article = parse(str(findArt))
            else:
                article="NONE"

            log(str(article), f)

            # -----INSERT IN DDB -----
            insertDDB([media, title, description, date, link, article])
            newArticles += 1
    pass
pass

date = time.strftime("%Y-%m-%d %H:%M:%S", time.gmtime())
timeScript = time.time() - start
log("Date                        : "+ date , f)
log("Nombre nouveaux articles    : "+ str(newArticles), f)
log("Nombre articles déjà en BDD : "+ str(alreadyInDB), f)
log("Nombre articles analysés    : "+ str(newArticles + alreadyInDB), f)
log("Durée du script             : "+ str(timeScript), f)
log("----------------------------------------------------- ", f)
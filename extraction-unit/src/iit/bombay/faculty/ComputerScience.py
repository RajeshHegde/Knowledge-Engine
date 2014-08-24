'''
Created on 28 Oct 2013

@author: RAJESH
'''
#System Library
from BeautifulSoup import BeautifulSoup
import urllib2
import logging
import json

#User Library
from database.mysql.connection import Connection
from common.faculty import Faculty


#Get IIT Madras Faculty Page
logging.basicConfig(filename='bombay_cs_faculty_list.log', level=logging.DEBUG)
logging.debug("Reading Bombay faculty list page")
try:
    request = urllib2.urlopen("http://www.cse.iitb.ac.in/page14")
    page = request.read().encode('utf8')
except Exception, e:
    print "Failed to read faculty webpage : %s" % e

logging.debug("Extract individual faculty details")
soup = BeautifulSoup(page)

#Get institute id
conn = Connection()
instituteID = conn.getInstituteID("Bombay")

tables = soup.find("table").findAll("table")[1:]

for table in tables:
    faculty_page_link = ""
    name = ""
    dept = ""
    designation = ""
    email = ""
    photo_href = ""
    research_field = []
    publications = []
    
    try:
        rows = table.findAll("tr")
        cells = rows[0].findAll("td")
        name =  cells[0].b.getText()
        dept = "CS"
        faculty_page_link =  cells[0].a.get("href")
        email =   cells[1].b.next + "@cs.iitb.ac.in"
        cells = rows[1].findAll("td")
        research_field =  cells[0].b.next.next
        if research_field :
            research_field =  research_field.split(",")
    except Exception, e:
        print "Failed to read required data : %s" % e
             
    #Store in DB
    faculty = Faculty()
    faculty.institute_id = instituteID
    faculty.faculty_name = name
    faculty.designation = designation
    faculty.department = dept
    faculty.faculty_email = email
    faculty.faculty_page = faculty_page_link
    faculty.photo_href = photo_href
    faculty.qualifications = ""
    faculty.research_field = json.dumps(research_field)
    faculty.publications = json.dumps(publications)
    conn.insertFaculty(faculty) 

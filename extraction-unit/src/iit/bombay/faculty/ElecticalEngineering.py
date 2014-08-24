'''
Created on 25 Oct 2013

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

#Get IIT Bombay EE Faculty Page
logging.basicConfig(filename='bombay_electrical_faculty_list.log', level=logging.DEBUG)
logging.debug("Reading Bombay faculty list page")
try:
    request = urllib2.urlopen("http://www.ee.iitb.ac.in/web/people/faculty")
    page = request.read().encode('utf8')
except Exception, e:
    print "Failed to read faculty webpage : %s" % e

#Get institute id
conn = Connection()
instituteID = conn.getInstituteID("Bombay")

logging.debug("Extract individual faculty details")
soup = BeautifulSoup(page)

rows = soup.findAll("table")[1].findAll("table")[1].find("tbody").findAll("tr")[1::2]

for row in rows[1:]:
    faculty_page_link = ""
    name = ""
    dept = ""
    designation = ""
    email = ""
    photo_href = ""
    research_field = []
    publications = []
    try:
        photo_href =  row.img.get("src")
        name =  row.a.getText()
        dept = "EE"
        faculty_page_link =  row.a.get("href")
        email =  row.a.get("href").split('/')[-1] + "@ee.iitb.ac.in"
        research_field =  row.find('strong')
        if research_field :
            research_field =  row.find('strong').next.next.split(",")
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


'''
links = soup.findAll("a")
homepageLinks = []
for link in links:
    href = link.get("href")
    if "http://www.ee.iitb.ac.in/web/faculty/homepage" in href:
        homepageLinks.append(href)
         
'''
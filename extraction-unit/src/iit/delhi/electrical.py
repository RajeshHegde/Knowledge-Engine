'''
Created on 15 Apr 2014

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

#Get IIT Delhi Electrical Faculty Page
logging.basicConfig(filename='delhi_Electrical_faculty_list.log', level=logging.DEBUG)
logging.debug("Reading Delhi Electrical faculty list page")
try:
    request = urllib2.urlopen("http://ee.iitd.ernet.in/people/complete_fac.html")
    page = request.read()
except Exception, e:
    print "Failed to read faculty webpage : %s" % e


#Get institute id
conn = Connection()
instituteID = conn.getInstituteID("Delhi")

logging.debug("Extract individual faculty details")
soup = BeautifulSoup(page)

tables = soup.find("div", attrs={"id": "main"}).findAll("table")

for table in tables:
    faculty_page_link = ""
    name = ""
    dept = ""
    designation = ""
    email = ""
    photo_href = ""
    research_field = []
    publications = []
    specialization = []
    try:
        for tr in table.findAll("tr"):
            name = tr.a.getText()
            dept = "EE"
            faculty_page_link =  "http://ee.iitd.ernet.in/people" + tr.a.get("href").strip(".")
            td = tr.findAll("td")
            email = td[0].findAll("br")[1].nextSibling.strip("\n").replace("Email:", "").replace("[AT]", "@")
            research_area = td[1].text.strip("Research Area:")
                         
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
    faculty.specialization = json.dumps(specialization)
    conn.insertFaculty(faculty) 

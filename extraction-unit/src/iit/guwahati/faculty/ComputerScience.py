'''
Created on 17 Nov 2013

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

#Get IIT Guwahati cs Faculty Page
logging.basicConfig(filename='guwahati_ccs_faculty_list.log', level=logging.DEBUG)
logging.debug("Reading Guwahati cs faculty list page")
try:
    request = urllib2.urlopen("http://www.iitg.ernet.in/cse/?page_id=150")
    page = request.read()
except Exception, e:
    print "Failed to read faculty webpage : %s" % e


#Get institute id
conn = Connection()
instituteID = conn.getInstituteID("Guwahati")

logging.debug("Extract individual faculty details")
soup = BeautifulSoup(page)

rows = soup.find("table").findAll("tr")

for row in rows[1:]:
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
        photo_href =  "http://www.iitg.ernet.in/cse/" + row.img.get("src")
        name =  row.u.getText()
        dept = "CS"
        faculty_page_link =  row.a.get("href")
        email =  row.find('strong', text = 'eMail  :').next
        designation = row.em.getText()
        research_field = row.find('strong', text = 'Research Interests :').next
    
        if research_field :
            research_field = research_field.split(",")
            
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

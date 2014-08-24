'''
Created on 15 Nov 2013

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

#Get IIT Guwahati civil Faculty Page
logging.basicConfig(filename='guwahati_civil_faculty_list.log', level=logging.DEBUG)
logging.debug("Reading Guwahati civil faculty list page")
try:
    request = urllib2.urlopen("http://www.iitg.ac.in/civil/fac.htm")
    page = request.read()
except Exception, e:
    print "Failed to read faculty webpage : %s" % e


#Get institute id
conn = Connection()
instituteID = conn.getInstituteID("Guwahati")

logging.debug("Extract individual faculty details")
soup = BeautifulSoup(page)

rows = soup.find("table", id='fac_names').findAll("tr")

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
        photo_href =  "http://www.iitg.ac.in/civil/" + row.img.get("src")
        name =  row.a.getText()
        dept = "CV"
        faculty_page_link =  row.a.get("href")
        email =  row.b.next.next[1:]
        
        research_field = row.findAll('p')[1]
        if research_field :
            research_field = row.findAll('p')[1].getText().split("*")
            
        if row.find('strong', text = 'Specialization: ').next:
            specialization = row.find('strong', text = 'Specialization: ').next
            
                
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

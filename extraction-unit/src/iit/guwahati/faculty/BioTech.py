'''
Created on 6 Apr 2014

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

#Get IIT Guwahati biotech Faculty Page
logging.basicConfig(filename='guwahati_biotech_faculty_list.log', level=logging.DEBUG)
logging.debug("Reading Guwahati biotech faculty list page")
try:
    request = urllib2.urlopen("http://www.iitg.ac.in/biotech/Faculty.html")
    page = request.read()
except Exception, e:
    print "Failed to read faculty webpage : %s" % e


#Get institute id
conn = Connection()
instituteID = conn.getInstituteID("Guwahati")

logging.debug("Extract individual faculty details")
soup = BeautifulSoup(page)

tables = soup.findAll("table")[3].findAll("table")[3]
rows = tables.findAll("tr")[1:]

for row in rows:
    faculty_page_link = ""
    name = ""
    dept = ""
    designation = ""
    email = ""
    photo_href = ""
    research_field = []
    publications = []
    specialization = []
    qualification = ""
    try:
        name, qualification  =  row.a.getText().split(",")
        dept = "BT"
        faculty_page_link =  row.a.get("href")
        if faculty_page_link.find("http") == -1:
            faculty_page_link = "http://www.iitg.ac.in/biotech/" + faculty_page_link  
            
        td = row.findAll("td")
        
        designation = td[1].getText()
        
        email =  td[2].getText()
                    
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
    faculty.qualifications = qualification
    faculty.research_field = json.dumps(research_field)
    faculty.publications = json.dumps(publications)
    faculty.specialization = json.dumps(specialization)
    conn.insertFaculty(faculty)
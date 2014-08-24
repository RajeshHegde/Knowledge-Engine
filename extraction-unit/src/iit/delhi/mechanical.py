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

#Get IIT Delhi Mechanical Faculty Page
logging.basicConfig(filename='delhi_Mechaical_faculty_list.log', level=logging.DEBUG)
logging.debug("Reading Delhi Mechanical faculty list page")
try:
    request = urllib2.urlopen("http://mech.iitd.ac.in/faculty.php")
    page = request.read()
except Exception, e:
    print "Failed to read faculty webpage : %s" % e


#Get institute id
conn = Connection()
instituteID = conn.getInstituteID("Delhi")

logging.debug("Extract individual faculty details")
soup = BeautifulSoup(page)

divs = soup.findAll("div", attrs={"class":"faculty"})

for div in divs:
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
        photo = div.img.get("src")
        name = div.a.getText()
        dept = "ME"
        faculty_page_link =  div.a.get("href")
        email = div.findAll('a')[1].getText()
        research_area = div.findAll("p")[2].getText()
                         
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

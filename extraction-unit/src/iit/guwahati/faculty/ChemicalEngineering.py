'''
Created on 7 Apr 2014

@author: RAJESH
'''
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

#Get IIT Guwahati ChemicalEngineering Faculty Page
logging.basicConfig(filename='guwahati_ChemicalEngineering_faculty_list.log', level=logging.DEBUG)
logging.debug("Reading Guwahati Chemical faculty list page")
try:
    request = urllib2.urlopen("http://www.iitg.ac.in/chemeng/faculty.html")
    page = request.read()
except Exception, e:
    print "Failed to read faculty webpage : %s" % e


#Get institute id
conn = Connection()
instituteID = conn.getInstituteID("Guwahati")

logging.debug("Extract individual faculty details")
soup = BeautifulSoup(page)

tables = soup.findAll("table")[1]
rows = tables.findAll("tr")[2::2]

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
        photo_href =  "http://www.iitg.ac.in/chemeng/" + row.img.get("src")
        name =  row.a.getText()
        dept = "CH"
        divs = row.findAll("td")[1].findAll("div")
        faculty_page_link =  "http://www.iitg.ac.in/chemeng/" + row.a.get("href")
        email =  divs[3].text.replace("&nbsp;", "").replace("E-mail : ", "")
        try:
            research_field = divs[7].text.replace("Key Research Areas :","")
            if research_field :
                research_field = research_field.split(",")
        except:
            research_field = []
                         
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

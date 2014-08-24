'''
Created on 4 Oct 2013

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
logging.basicConfig(filename='madras_faculty_list.log', level=logging.DEBUG)
logging.debug("Reading madras faculty list page")
try:    
    request = urllib2.urlopen("http://www.iitm.ac.in/fsportal/iitmsite/listfaculty")
    page = request.read().encode('utf8')
except Exception, e:
    print "Failed to read faculty list webpage : %s" %e
    logging.debug("Failed to read faculty list webpage")

logging.debug("Finished reading faculty list page")

#Get institute id
conn = Connection()
instituteID = conn.getInstituteID("Madras")

#Get faculty pages
logging.debug("Get faculty list")
soup = BeautifulSoup(page)
rows = soup.find("table").find("tbody").findAll("tr")


'''
For debug
f = open('madras_faculties.csv', 'w')
'''

for row in rows:
    cells = row.findAll("td")
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
        faculty_page_link = "http://www.iitm.ac.in" + cells[0].find('a').get('href')
        name = cells[1].getText()
        dept = cells[2].getText()
        designation = cells[3].getText()
        email = cells[5].getText() + '@iitm.ac.in'
        
        #Reading faculty page
        logging.debug("Reading faculty page : %s", faculty_page_link)
        try:  
            faculty_page = urllib2.urlopen(faculty_page_link).read().encode('utf8')
        except Exception, e:
            print "Failed to read faculty page : %s" % e
            
        faculty_page_soup = BeautifulSoup(faculty_page)
        photo_href = faculty_page_soup.findAll('img')
        if len(photo_href) > 1:
            photo_href = faculty_page_soup.findAll('img')[1].get('src')
        else:
            photo_href = ""
        if faculty_page_soup.find('img'):
            photo_href = faculty_page_soup.findAll('img')[1].get('src')
        if faculty_page_soup.find('strong', text = 'Research Interests'):
            researchInterestList = faculty_page_soup.find('strong', text = 'Research Interests').findNext().findAll('li')
            for i in researchInterestList:
                research_field.append(i.text)
        if faculty_page_soup.find('strong', text = 'Publications'):
            publicationsList = faculty_page_soup.find('strong', text = 'Publications').findNext().findAll('li')
            for i in publicationsList:
                publications.append(i.text)               
            
    except Exception, e:
        print "Failed to read required data : %s" % e
        continue
    
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
    faculty.publications = json.dumps(specialization)
    conn.insertFaculty(faculty)
        
'''
    For debug
    delim = "##"
    f.write(name + delim)
    f.write(dept + delim)
    f.write(designation + delim)
    f.write(email + delim)
    f.write(faculty_page_link + delim)
    f.write("$$".join(interests) + delim)
    f.write("$$".join(publications) + delim)
    f.write("\n")
    
    

faculty_pages = []
for link in soup.findAll('a'):
    if 'fsportal//iitmsite/fac' in link.get('href'):
        href = "http://www.iitm.ac.in" + link.get('href')
        faculty_pages.append(href)
        logging.info('link : %s', href)



logging.debug("Extract each faculty details")
for faculty in faculty_pages:
    logging.debug("Reading faculty page : %s", faculty)
    page = urllib2.urlopen(faculty).read()
    soup = BeautifulSoup(page)
    researchInterest = soup.find('strong', text = 'Research Interests').findNext().findAll('li')
    for interest in researchInterest:
        interest.text

    publications = soup.find('strong', text = 'Research Interests').findNext().findAll('li')
    for publication in publications:
        publication.text    
    
soup.find(id="block-system-main").div.div
photo - content.p.img.get('src')
name - content.h2.text

researchInterest = soup.find('strong', text = 'Research Interests').findNext().findAll('li')
for interest in researchInterest:
    interest.text


publications = soup.find('strong', text = 'Research Interests').findNext().findAll('li')
for publication in publications:
    publication.text
'''

'''
Created on 4 Oct 2013

@author: RAJESH
'''
import MySQLdb
import logging

class Connection:
    def __init__(self):
        self.host = "localhost"
        self.user = "rajesh"
        self.db = "knowledge_engine"
        self.password = "rajesh"
        self.connection = MySQLdb.connect(host = self.host, user = self.user, passwd = self.password, db = self.db, use_unicode=True)
        self.cursor = self.connection.cursor()
        logging.basicConfig(filename='database_log.log', level=logging.DEBUG)

    def execute(self, query):    
        try:
            self.cursor.execute(query)
            self.connection.commit()
        except MySQLdb.Error, e:
            print "Error %d: %s" % (e.args[0], e.args[1])
            #self.cursor.rollback()
    
    def close(self):
        try:
            self.connection.close()
        except MySQLdb.Error, e:
            print "Error in Connection.close method:" 
            print "Error %d: %s" % (e.args[0], e.args[1])
        
        
    def insertFaculty(self, faculty):
        try:
            statement = '''INSERT IGNORE INTO faculty(institute_id, faculty_name, designation, dept_code, photo_href, faculty_email, qualifications, research_field, publications, faculty_page, specialization) 
                            VALUES(%s, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')
                        ''' % (faculty.institute_id, faculty.faculty_name, faculty.designation, faculty.department, faculty.photo_href,  faculty.faculty_email, faculty.qualifications, faculty.research_field, faculty.publications, faculty.faculty_page,  faculty.specialization )
            print statement
            logging.info(statement)
            self.execute(statement)
        except MySQLdb.Error, e:
            print "Error in Connection.insertFaculty method:"
            print "Error %d: %s" % (e.args[0], e.args[1])
                    
    def getInstituteID(self, instuteName):
        try:
            statement = "SELECT institute_id FROM institute WHERE institute_name LIKE '%" + instuteName +"%'"
            self.execute(statement)
            instituteID = self.cursor.fetchone()
            return  int(instituteID[0])
        except MySQLdb.Error, e:
            print "Error in Connection.getInstituteID method:"
            print "Error %d: %s" % (e.args[0], e.args[1])
        
        
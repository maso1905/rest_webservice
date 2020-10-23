# Description

This is a REST webservice which uses a MySQL database with Phpmyadmin at MIUN server. It has full CRUD functionality with classes
to read stored courses I have finished and my recent curriculum vitae information such as Work and Education.

## To test functionality of the database, you can use Advanced Rest Client or Postman to display results.

### Test Education:

Request:
* GET - http://studenter.miun.se/~maso1905/dt173g/rest/cv_work_edu/education.php
* GET - http://studenter.miun.se/~maso1905/dt173g/rest/cv_work_edu/education.php?id=1
* POST - http://studenter.miun.se/~maso1905/dt173g/rest/cv_work_edu/education.php '{"school": "schoolname", "program": "programname", "start": "2000-01-01", "end": "2000-02-02"}'
* PUT - http://studenter.miun.se/~maso1905/dt173g/rest/cv_work_edu/education.php?id=1 '{"school": "schoolname", "program": "programname", "start": "2000-01-01", "end": "2000-02-02"}'
* DELETE - http://studenter.miun.se/~maso1905/dt173g/rest/cv_work_edu/education.php?id=1

### Test Work:

Request:
* GET - http://studenter.miun.se/~maso1905/dt173g/rest/cv_work_edu/work.php
* GET - http://studenter.miun.se/~maso1905/dt173g/rest/cv_work_edu/work.php?id=1
* POST - http://studenter.miun.se/~maso1905/dt173g/rest/cv_work_edu/work.php '{"company": "companyname", "title": "titlename", "start": "2000-01-01", "end": "2000-02-02"}'
* PUT - http://studenter.miun.se/~maso1905/dt173g/rest/cv_work_edu/work.php?id=1 '{"company": "companyname", "title": "titlename", "start": "2000-01-01", "end": "2000-02-02"}'
* DELETE - http://studenter.miun.se/~maso1905/dt173g/rest/cv_work_edu/work.php?id=1

### Test Course:

Request:
GET - http://studenter.miun.se/~maso1905/dt173g/rest/miun_courses/course.php
GET - http://studenter.miun.se/~maso1905/dt173g/rest/miun_courses/course.php?id=1
POST - http://studenter.miun.se/~maso1905/dt173g/rest/miun_courses/course.php '{"name": "coursename", "code": "coursecode", "prog": "A", "syllabus": "http link"}'
PUT - http://studenter.miun.se/~maso1905/dt173g/rest/miun_courses/course.php?id=1 '{"name": "coursename", "code": "coursecode", "prog": "A", "syllabus": "http link"}'
DELETE - http://studenter.miun.se/~maso1905/dt173g/rest/miun_courses/course.php?id=1

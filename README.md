# Question-Answer-Website


Welcome to our Question and Answer platform, a versatile and interactive web application designed to facilitate knowledge sharing and learning within a dynamic community. Built using PHP, HTML, CSS, SQL, and JavaScript, our application provides a robust and seamless user experience. It has been hosted using MAMP for PHP and phpMyAdmin for SQL, which ensures smooth performance and database management.

Our platform has been meticulously designed and constructed to provide a structured and organized system for users to ask questions, receive answers, and engage with the community. We have incorporated a range of features, including registration, login, search, topics, and user profiles. Additionally, the application includes an event scheduler and an automated system for updating user statuses based on their contributions and expertise.

The ER Diagram, Relational Schema, and assumptions made during the design process have been documented for reference, and we have provided Create Table Statements and SQL Queries to manage the database effectively. Furthermore, we have populated the tables to ensure a rich and diverse knowledge base is available for users to explore.

Some of the key features of our platform include:

Registration and Login: Users can quickly sign up and log in to access the platform's functionalities.
Main Page: A user-friendly interface that displays recent questions and popular topics.
Search: Users can search for questions or topics to find relevant information.
Topics: Users can browse and select from a list of parent topics and subtopics to find questions and answers related to their interests.
User Profile: Users can view and edit their profile, track their status, and view their contributions.
Updating User Status: A procedure runs regularly to update the status and score of users based on their contributions to the platform.
Event Scheduler: Automatically updates and manages events within the platform.
Signout: Users can securely log out of the platform.
Post a Question: Users can ask questions and associate them with relevant topics.
View Selected Question: Users can view a selected question, its answers, and interact with the content by selecting the best answer or giving a thumbs up.

We believe our Question and Answer platform offers a comprehensive and engaging experience for users, making it an invaluable resource for knowledge sharing and learning. We invite you to explore the platform and enjoy its features!

## Relational Schema

Note: Primary keys are underlined and highlighted in red

<img width="633" alt="image" src="https://user-images.githubusercontent.com/58552741/235363554-1529cfd3-d626-4289-b30a-938a0262d07a.png">


## Create Table Statements

CREATE TABLE topic
  (
     topic_id        INTEGER PRIMARY KEY,
     topic_name      VARCHAR(20) NOT NULL,
     parent_topic_id INTEGER
);

CREATE TABLE status
  (
     status_id        INTEGER PRIMARY KEY,
     status_name      VARCHAR(20) NOT NULL,
     status_min_score INTEGER NOT NULL,
     status_max_score INTEGER
);

CREATE TABLE users
  (
     user_id       INTEGER PRIMARY KEY,
     user_name     VARCHAR2(20) NOT NULL,
     user_password VARCHAR2(20) NOT NULL,
     phone_number  INTEGER NOT NULL,
     email         VARCHAR2(30),
     city          VARCHAR2(20),
     state         VARCHAR2(20),
     user_profile  VARCHAR2(50),
     status_id     INTEGER NOT NULL,
     CONSTRAINT unique_user_name UNIQUE (user_name),
     FOREIGN KEY (status_id) REFERENCES status(status_id)
);

CREATE TABLE question
  (
     que_id     INTEGER PRIMARY KEY,
     user_id    INTEGER NOT NULL,
     que_title  VARCHAR(100) NOT NULL,
     que_text   VARCHAR(200) NOT NULL,
     topic_id   INTEGER NOT NULL,
     time_asked TIMESTAMP NOT NULL,
     is_active  INTEGER NOT NULL,
     FOREIGN KEY (user_id) REFERENCES users(user_id),
     FOREIGN KEY (topic_id) REFERENCES topic(topic_id)
);

CREATE TABLE answer
  (
     ans_id        INTEGER PRIMARY KEY,
     que_id        INTEGER NOT NULL,
     ans_text      VARCHAR2(4000) NOT NULL,
     user_id       INTEGER NOT NULL,
     time_answered TIMESTAMP NOT NULL,
     is_best       NUMBER(1, 0) NOT NULL,
     FOREIGN KEY (user_id) REFERENCES users (user_id),
     FOREIGN KEY (que_id) REFERENCES question(que_id)
  ); 

CREATE TABLE thumbs_up
  (
     ans_id     INTEGER NOT NULL,
     user_id    INTEGER NOT NULL,
     time_liked TIMESTAMP NOT NULL,
     FOREIGN KEY (user_id) REFERENCES users(user_id),
     FOREIGN KEY (ans_id) REFERENCES answer(ans_id)
);

## Site Features 
### Registration

A new user account is created using the registration page.
All the registration fields are mandatory
- Username
- Password
- Phone Number - Email
- City
- State
- Profile
Account creation validation and checks:
- Username has to be Unique
- Both password and re-enter password should match - Phone number has to be a 10-digit number
- Email has to be valid
On successful registration we are able to redirect to Login otherwise
the Respective validation error corresponding to the form field is
shown on the same page.

A Reset button is present to clear the form if there are pre-filled
values or multiple changes to be made in the form.

<img width="1048" alt="image" src="https://user-images.githubusercontent.com/58552741/235363876-3650682a-f844-4a18-ae96-258f9f28db40.png">

### Login :
After a user account is created. Users can login using the login page
passing username and password.
Checks and Validation:
- If the given username is present or not.
- If the password matches corresponding to the username
After a successful login a session is created for the user.
In case a user doesn't have an account a signup link is provided at
the bottom.

<img width="1000" alt="image" src="https://user-images.githubusercontent.com/58552741/235363919-523205e9-b740-4265-896b-0e5f8a889abe.png">

A new user account is created using the registration page.

### Main Page
All the User activity is presented on this page in reverse
chronological order.
User Activities such as
- Questions posted by user
- Answers provided by user
- Any new comments on the answer provided by user
There is also a menu bar at the right side. - Search
- Topics
- User Profile
- Post a Question - Signout

<img width="680" alt="image" src="https://user-images.githubusercontent.com/58552741/235364068-a20138d3-e97a-41f6-9e08-3b791d3fbb19.png">

### Search
Filter and result the questions which have the search keyword either
in Question Title or Question Text.

<img width="694" alt="image" src="https://user-images.githubusercontent.com/58552741/235364154-2399ef37-ad93-4122-8fa4-1df5cb0b1edb.png">


### Topics
Redirects to a new page where there is a List of all the topics and
number of questions related to each topic that have been asked so far.
Clicking on each topic redirects to all the questions asked related to
that topic.

<img width="634" alt="image" src="https://user-images.githubusercontent.com/58552741/235364192-a8ea15b2-a439-4abb-b080-92b94d7fb62e.png">


### User Profile
All the information regarding the user is shown on this page.
Including the Status of the user i.e, beginner, Expert or Advance.

<img width="634" alt="image" src="https://user-images.githubusercontent.com/58552741/235366446-c7793c5a-c130-4c88-ab8d-774c6b621586.png">

#### Updating User Status
- We have created a Stored procedure which is called every 15 seconds to update the user status based on the criteria discussed above.
Procedure:
<img width="679" alt="image" src="https://user-images.githubusercontent.com/58552741/235366524-e2bfda78-29a1-4e24-9729-58cae69eda23.png">
<img width="679" alt="image" src="https://user-images.githubusercontent.com/58552741/235366540-3d81a781-40ba-4e38-b1db-13329a3eb496.png">


### Signout 
- Logs the user out and Ends the session and session data of the user logged in.

### Post a Question
A user will be able to post questions, They will be able to add a question title, question text (Information for users to be able to answer the question) and choose a tag related to the question.

All three fields are mandatory to post a question, once the user clicks the submit button, the fields are validated to make sure they have been filled and then the question gets added to the database.
 <img width="638" alt="image" src="https://user-images.githubusercontent.com/58552741/235366590-32ca94b2-50d2-4930-a3c1-5937debed11d.png">


### View Selected Question
The user will be able to select a question to view its answers. The user will also be able to post answers to the question and like/unlike answers.
Once the users likes an answer the color of the like button will change to red and when they click on the button again, they will unlike the answer and color will change to gray.
All the answers that the user has already liked will have the red like button.
The user can select the add answer button to post an answer to the question.
All answers to the question will appear in reverse chronological order.

<img width="638" alt="image" src="https://user-images.githubusercontent.com/58552741/235366606-63d77f58-6c79-40fa-ae59-43e922f1afb6.png">

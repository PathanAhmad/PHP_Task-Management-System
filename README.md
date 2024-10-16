# Task Management System

This project implements a web-based Task Management System that allows users to add, edit, delete, and view tasks. The application is built using PHP for the backend and MySQL for the database, ensuring data is stored securely and efficiently. The system is designed to help users manage their tasks effectively.

## Objective

The main goal of this project is to create a user-friendly platform where individuals can keep track of their tasks. Users can input task names, descriptions, and due dates, and manage their task list through a simple web interface.

## Features Implemented

### 1. **Task Creation**
- Users can fill out a form to create new tasks. The form includes fields for:
  - **Task Name**: A brief title for the task.
  - **Description**: Detailed information about the task.
  - **Due Date**: The deadline for the task.

### 2. **Input Validation**
- Server-side validation is performed using PHP to ensure that all necessary information is provided before a task is added to the database. This helps maintain data integrity.

### 3. **Task Listing and Viewing**
- After logging in, users can view a list of all their tasks. The dashboard displays:
  - Task names
  - Descriptions
  - Due dates
- Each task can be clicked to view more details, making it easy to manage and track progress.

### 4. **Task Update and Delete**
- Users have the ability to edit existing tasks. They can update:
  - Task name
  - Description
  - Due date
- There is also an option to delete tasks, with confirmation prompts to prevent accidental deletions.

### 5. **Database Integration**
- The system integrates seamlessly with a MySQL database to perform CRUD (Create, Read, Update, Delete) operations. PHP is used to handle interactions between the application and the database.
- Error handling is implemented to manage exceptions gracefully, ensuring that users receive helpful messages if something goes wrong.

### 6. **Optimization**
- Database queries are optimized for performance, including indexing important columns to speed up search operations.

## Project Structure

- **index.php**: The main entry point where users can log in and access the application.
- **login.php**: Handles user authentication and redirects to the task dashboard upon successful login.
- **task.php**: Contains functionalities for adding, updating, and deleting tasks.
- **db_connect.php**: Responsible for connecting to the MySQL database.
- **style.css**: Contains styles for the web application, enhancing the user interface.

## Hosting

I will be hosting this application on **infinityfree.com**, which provides free web hosting services. This will allow users to access the Task Management System online without needing to set up a local environment. 

### Steps for Hosting:
1. **Create an Account**: I will sign up for an account on infinityfree.com.
2. **Upload Files**: Using the file manager or an FTP client, I will upload all project files to the server.
3. **Database Setup**: I will create a MySQL database on infinityfree.com and import the necessary schema for the tasks.
4. **Configuration**: I will update the `db_connect.php` file with the new database credentials to ensure the application connects to the hosted database.
5. **Access**: Once hosted, I will share the link for users to access the Task Management System.

## Future Improvements

- **User Authentication**: Currently, the project does not implement user registration. Adding a user registration feature would allow multiple users to manage their tasks independently.
- **Task Filtering and Sorting**: Implementing sorting options for tasks (e.g., by due date or priority) would enhance usability.
- **Mobile Optimization**: Although the current design is responsive, further tweaks could improve the user experience on smaller screens.

## Conclusion

This Task Management System is designed to be a simple yet effective tool for managing tasks. By hosting it online, I aim to provide easy access for users to organize their work. The project allows for further enhancements, making it a great base for future development.

## Project Title:
- Digital Learning Platform
## Description
- A web-based platform for students and educators(admins) to create, share, and manage online courses. 
This project includes features such as user authentication, course creation, filtering, messaging and real-time 
notification.

## Features
- Real-time notifications and messages using Laravel Websockets and Laravel Echo.
- User authentication with role-based access (e.g., admin, instructor, student).
- Course creation, filtering, and management.
- Messaging system with reply functionality.


## Technologies Used
- **Laravel**: Backend framework for PHP.
- **Laravel Echo**: For real-time event broadcasting.
- **Laravel Websockets**: Handles WebSocket connections for real-time updates.
- **Vue.js**: Frontend JavaScript framework for building interactive UIs.
- **Inertia.js**: Bridges Laravel and Vue.js to build single-page applications (SPAs).
- **MySQL**: Relational database to store course and user data.


## Installation
1. Clone the repository: `git clone git@github.com-personal:ayenadikyaw/edu_learn.git`
2. Navigate to the project directory: `cd edu_learn`
3. Install dependencies:  
   - For backend: `composer install`  
   - For frontend: `npm install`
4. Set up the `.env` file with your database and email configurations.
5. Run migrations: `php artisan migrate --seed`
6. Laravel WebSockert server start: `php artisan reverb:start`
7. Start the development server: `php artisan serve`
8. Compile frontend assets: `npm run dev`

## Database Setup (Optional)
If you find uncomfortable to run migrations, can import the included SQL file that you may find in project folder.
Import the included SQL file (`edu_learn.sql`) into your database:

## Usage
- Visit the homepage at `http://localhost:8000` to explore available courses.
- Use the admin dashboard to create and manage courses.
- Try the messaging system for sending and replying to messages.
- sample admin account: admin@gmail.com , admin123
- sample user account: user@gmail.com, user123456


## Author
Developed by [Ayenadikyaw](mailto:ayenadykyaw1@gmail.com)



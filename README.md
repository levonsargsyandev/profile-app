## Installation


- Clone the project from [git link](https://github.com/levonsargsyandev/profile-app).
- Open terminal from project directory
- Run <span style="color:#b54522;">composer install</span>
- Create <span style="color:#b54522;">.env</span> file from <span style="color:#b54522;">.env.example</span> instance in the root directory of the project
- Create a new database and fill <span style="color:#b54522;">DB_DATABASE</span>, <span style="color:#b54522;">DB_USERNAME</span> and <span style="color:#b54522;">DB_PASSWORD</span> fields in the <span style="color:#b54522;">.env</span> file.
- Run <span style="color:#b54522;">php artisan migrate</span>
- Run <span style="color:#b54522;">php artisan key:generate</span>
- Run <span style="color:#b54522;">npm install</span>
- Run <span style="color:#b54522;">php artisan serve</span>

## Answers to questions

**1. What was your approach to this project? Did it change as you developed the app further?**

*My approach to this project was to create clear, readable code. To complete all task requirements and finish on deadline. Since this is a test assignment, I would change my approach in the case of a real project.*

**2. What were the challenges you faced?**

*The challenges were to create authentication with Laravel sanctum, validate the data on the backend part, run the application on a live server.*

**3. How differently will you do if you had a couple of more days to complete the assignment? What if you have one full month?**

*I don't think this task would have taken a whole month anyway but if I had more time to complete it, I would do the following important improvements.*


Front end

- have a separate front end directory with Vue CLI or React

- change component system and split into more reusable components

- forms validation

- write test cases for components

- redesign

Back end

- have a separate back end directory with Laravel as an API

- more strong authentication system

- make separate FormRequest files for each request

- throw error or success messages describing in detail to the client-side

- more and detailed test cases


## Live Demo Link

- [http://testassignment.xyz](http://testassignment.xyz)




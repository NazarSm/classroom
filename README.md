
## Installation

```bash
1) git clone
2) composer install
3) settings .env file
4) symfony doctrine:migrations:migrate
5) symfony doctrine:fixtures:load

```
## Usage

*adding header "api-token" - "123qweasdzxc" to all request

```python

# creatin Classroom:
method - POST
ENDPOINT - your_localhost/classroom/new
Request params : 
name, is_active

# showing Classroom ENDPOINT:
method - GET
ENDPOINT - your_localhost/classroom/show/{classroom_id}

# update Classroom ENDPOINT:
method - POST
ENDPOINT - your_localhost/classroom/update/{classroom_id}
Request params : 
name, is_active

# removing Classroom ENDPOINT:
method - DELETE
ENDPOINT - your_localhost/classroom/delete{classroom_id}

# classrooms list ENDPOINT:
method - GET
ENDPOINT -  your_localhost/classroom/
Request params:
page - page number
perPage - number of items per page

# change status classroom ENDPOINT:
method - GET
ENDPOINT - your_localhost/classroom/change-status/{classroom_id}
```
## Installation

```bash
1) git clone
2) composer install
3) settings .env file
4) symfony doctrine:migrations:migrate
5) symfony doctrine:fixtures:load

```
## Usage

*adding header "api-token" - "123qweasdzxc" to all request

```python

# creatin Classroom:
method - POST
ENDPOINT - your_localhost/classroom/new
Request params : 
name, is_active

# showing Classroom ENDPOINT:
method - GET
ENDPOINT - your_localhost/classroom/show/{classroom_id}

# update Classroom ENDPOINT:
method - POST
ENDPOINT - your_localhost/classroom/update/{classroom_id}
Request params : 
name, is_active

# removing Classroom ENDPOINT:
method - DELETE
ENDPOINT - your_localhost/classroom/delete{classroom_id}

# classrooms list ENDPOINT:
method - GET
ENDPOINT -  your_localhost/classroom/
Request params:
page - page number
perPage - number of items per page

# change status classroom ENDPOINT:
method - GET
ENDPOINT - your_localhost/classroom/change-status/{classroom_id}
```

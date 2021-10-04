# exam

## REGISTER - POST
```
URL:              /kumu_exam/register  
REQUEST BODY:
{
    "username": "sample",
    "password": "P@ssw0rd123"
}

RESPONSES:
200 - OK
{
    "response": "Registration Success"
}

422 - Unprocessable Entity
500 - Internal Server Error
```


## GET USER LIST - POST
```
URL:              /kumu_test/getUsers  
REQUEST HEADER:   Basic base64(username:password)  
REQUEST BODY:  

[  
  {
   "username":"a"
  },
  {
    "username":"joshpena15"
  }
]  

RESPONSES:
200 - OK
[
    {
        "name": "Shuvalov Anton",
        "login": "A",
        "company": null,
        "followers": 463,
        "public_repos": 46,
        "avg_followers": 10
    },
    {
        "name": "Joshua Peña",
        "login": "joshpena15",
        "company": null,
        "followers": 0,
        "public_repos": 2,
        "avg_followers": 0
    }
]

401 - Unauthorized
422 - Unprocessable Entity
422 - Maximum Queries Reached
```

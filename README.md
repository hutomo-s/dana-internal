
# Dana Internal - Exception Paper

This project is to solve the need of automated approval line for Exception Paper.

## Features

- Login (without password)
- Create New User
- Create Exception Paper
- View Exception Paper
- Approve Exception Paper
- Download Generated PDF of Exception Paper


## Environment Variables

To run this project, you will need to add the following environment variables to your .env file

`CI_ENVIRONMENT`

`app.baseURL`

`database.default.hostname`

`database.default.database`

`database.default.username`

`database.default.password`

`database.default.DBDriver`

`database.default.DBPrefix`

`database.default.port`

`MAILTRAP_API_KEY`

`MAILTRAP_INBOX_ID`
## Tech Stack

**Client Side:** 
- Jquery v3.6.0
- Bootstrap v4.6.1

**Server Side:**
- PHP 8.2.27
- MySQL 8.4

**Framework:**
- Codeigniter v4.6.0

**Libraries:**
- AdminLTE 3
- MPDF v8.2.5
- Mailtrap



## Entity Relationship Diagram

Entity-Relationship Diagram for Dana Exception Papers

![ERD](https://raw.githubusercontent.com/hutomo-s/dana-internal/refs/heads/master/public/assets/image/dana_exception_paper_erd.webp)

## Activity Diagram

Activity Diagram for Dana Exception Papers

![Actitivity Diagram](https://raw.githubusercontent.com/hutomo-s/dana-internal/refs/heads/master/public/assets/image/dana_exception_paper_activity_diagram.webp)



## Status Codes

Below is the allowed values of field `exception_papers.exception_status` (smallint) 

| Status ID | Status Code | Description
| --- | --- | ---
| 1 | CREATED_BY_REQUESTOR | First Status on EP Creation, Waiting Approval from Line Manager
| 2 | APPROVED_BY_LINE_MANAGER | After Approved by Line Manager, Waiting Approval from Excom I
| 3 | APPROVED_BY_EXCOM_1 | After Approved by Excom I, Waiting Approval from Excom II
| 4 | APPROVED_BY_EXCOM_2 | After Approved by Excom I
| 5 | APPROVED_BY_CEO | After Approved by CEO
| 6 | SUBMITTED_TO_PROCUREMENT | EP is Submitted and Approval is Completed



## Authors

- [@hutomo-s](https://github.com/hutomo-s)


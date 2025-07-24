# workplace
Symfony web app for managing workplace (vacation days calculator, remote work, timers, requests for leave) 

## TODO:

### 1. Project Setup

#### Easy:  
- Create Symfony project and configure .env

#### Medium:  
- Set up Docker (nginx, PHP, MySQL/PostgreSQL, Mailhog)
- Set up basic security (JWT or session login)
- Configure roles: ROLE_USER, ROLE_MANAGER, ROLE_ADMIN

### 2. User Management

#### Easy:  
- Registration & Login
- Profile page with editable field
  
#### Medium:  
- Role-based access control (Voters or Security annotations)
- Manager/admin can create/update/delete users
- Password reset flow (email + token)

### 3. Vacation Days Calculator

#### Easy:  
- Add annual vacation allowance field to user
 
#### Medium:
- Track used vs remaining vacation days
- Auto-calculate accrued days per month/year
  
#### Hard:
- Handle custom rules (carryover, probation period limits)

### 4. Remote Work Requests

#### Easy:  
- Submit remote work request (date, reason) 
 
#### Medium:
- Approval flow (manager approval + notifications)
- Conflict detection with vacation/sick days
- Reporting dashboard for remote work stats

### 5. Leave Requests (Vacation, Sick, etc.)

#### Easy:  
- Submit leave request form
- Leave type selection (vacation, sick, unpaid, etc.)

#### Medium:
- Notification system (email + in-app)
- PDF generation of leave summaries (optional)

#### Hard:
- Calendar view of all team members' leaves 

### 6. Timers / Working Hours Tracking

#### Easy:
- Export to CSV or Excel 

#### Medium:
- Start/Stop timer (daily working hours)
- Auto-stop at certain hour (optional)
- Admin report (weekly/monthly totals) 

#### Hard:
- Overtime tracking

### 7. Notifications

#### Medium:
- Basic in-app notification system
- Email notification service (e.g., Symfony Mailer)

#### Hard:
- Slack/Teams webhook integration (optional)


### 8. Admin Dashboard

#### Medium:
- View all users, vacation status, remote work
- Filters by department, manager, date

#### Hard:
- KPI metrics (total vacation taken, remote days, etc.)


### 9. Frontend

#### Hard:
- Interactive calendar with vacation overlays


### 10. Tests & QA

#### Easy:
#### Medium:
- Unit tests for services (vacation calc logic, timers)
- Functional tests (login, forms, workflows)
- API tests
#### Hard:

### 11. Deployment

#### Easy:
#### Medium:
- Set up CI/CD (GitHub Actions, GitLab CI, etc.)
- Staging environment with test DB
#### Hard:
- Production setup (Caddy/nginx, HTTPS, supervisor for queue workers)

  
## UI:

### Simple sketch
<img width="889" height="594" alt="obraz" src="https://github.com/user-attachments/assets/191bfe8f-f614-402b-98c5-21fa05e51cb0" />  

### Figma

https://www.figma.com/design/KojiPduRF3mEiwaKwdt31A/Workplace-webapp?node-id=0-1&t=jAAwjgZNiQN5LpSE-1

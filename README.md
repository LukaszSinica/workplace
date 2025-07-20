# workplace
Symfony web app for managing workplace (vacation days calculator, remote work, timers, requests for leave) 

## TODO:
### Easy:
- Navigation  
- Breadcrumbs  
- Registration & Login  
- Profile page with editable field  
- Submit remote work request (date, reason)  
- Submit leave request form
- Export to CSV or Excel 
- Leave type selection (vacation, sick, unpaid, etc.)

### Medium:
- Track used vs remaining vacation days
- Auto-calculate accrued days per month/year
- Set up Docker (nginx, PHP, MySQL/PostgreSQL, Mailhog)
- Set up basic security (JWT or session login)
- Configure roles: ROLE_USER, ROLE_MANAGER, ROLE_ADMIN
- Role-based access control (Voters or Security annotations)
- Manager/admin can create/update/delete users
- Password reset flow (email + token)
- Approval flow (manager approval + notifications)
- Conflict detection with vacation/sick days
- Reporting dashboard for remote work stats
- Notification system (email + in-app)
- PDF generation of leave summaries (optional)
- Auto-stop at certain hour (optional)
- Admin report (weekly/monthly totals)
- Basic in-app notification system
- Email notification service (e.g., Symfony Mailer)
- View all users, vacation status, remote work
- Filters by department, manager, date
- Unit tests for services (vacation calc logic, timers)
- Functional tests (login, forms, workflows)
- Set up CI/CD (GitHub Actions, GitLab CI, etc.)
- Staging environment with test DB

### Hard:
- Handle custom rules (carryover, probation period limits) 
- Calendar view of all team members' leaves 
- Overtime tracking
- Slack/Teams webhook integration (optional)
- KPI metrics (total vacation taken, remote days, etc.)
- Interactive calendar with vacation overlays
- Production setup (Caddy/nginx, HTTPS, supervisor for queue workers)
  
## UI:

### Simple sketch
<img width="889" height="594" alt="obraz" src="https://github.com/user-attachments/assets/191bfe8f-f614-402b-98c5-21fa05e51cb0" />

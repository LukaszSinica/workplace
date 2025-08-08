export async function loginUser(LoginData: { email: string, password: string}) {
    const res = await fetch('http://localhost/api/login', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        mode: 'cors',
        credentials: 'include', // if using cookies/session
        body: JSON.stringify({username: LoginData.email, password: LoginData.password}),
      });
    return res.json();
}

export async function vacationRequestCreate(vacationRequestData: { date_from: string, date_to: string, reason: string}) {
  const res = await fetch('http://localhost/api/vacation_request/create', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      mode: 'cors',
      credentials: 'include',
      body: JSON.stringify(
        {
          date_from: vacationRequestData.date_from, 
          date_to: vacationRequestData.date_to, 
          reason: vacationRequestData.reason
        }
      ),
    });
  return res.json();
}
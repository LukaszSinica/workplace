export async function loginUser(LoginData: { email: string, password: string}) {
    console.log(LoginData);
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
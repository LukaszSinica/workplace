"use server";
import { cookies } from "next/headers";
import { redirect } from "next/navigation";

export async function vacationRequestCreate(vacationRequestData: { date_from: string, date_to: string, reason: string}) {
  const cookieStore = await cookies();
  const res = await fetch('http://localhost/api/vacation_request/create', {
      method: 'POST',
      headers: {
        Cookie: (await cookieStore).toString()
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

export async function vacationRequestList() {
    const cookieStore = await cookies();
    const token = cookieStore.get("AUTH_TOKEN")?.value;
    const res = await fetch('http://localhost/api/vacation_request/list', {
        method: 'GET',
        headers: {
          Authorization: `Bearer ${token}`,
        },
        mode: 'cors',
        credentials: 'include',
        
    });
    return res.json();
  
}


export async function getProfileData() {
  try {
    const cookieStore = await cookies();
    const token = cookieStore.get("AUTH_TOKEN")?.value;
    const res = await fetch('http://localhost/api/profile', {
      method: 'GET',
      headers: {
        Authorization: `Bearer ${token}`,
      },
      mode: 'cors',
      credentials: 'include',
      
    });
    return res.json();

  } catch (error) {
    return {};
  }
}

export async function signOut() {
  const cookieStore = await cookies();
  const token = cookieStore.get("AUTH_TOKEN")?.value;
  try {
    const res = await fetch('http://localhost/api/logout', {
      method: 'POST',
      headers: {
        Authorization: `Bearer ${token}`,
      },
      mode: 'cors',
      credentials: 'include',
      
    });
    cookieStore.delete("AUTH_TOKEN");
    console.log(res.json);
  } catch (error) {
    console.error("Logout error:", error);
  }
}
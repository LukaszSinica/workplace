import { getUserData } from '@/lib/actions';
import React from 'react'

export default async function Profile() {
  const userData = await getUserData();
  

  return (
    <main className="flex flex-col items-center w-full h-screen p-4">
        <h1 className='text-2xl font-bold'>Profile</h1>
        <div className="flex flex-row mt-8 w-full "> 
            <section className='w-1/3'>
                <img src="/profile_img.jpg" className='h-100 w-100' />
            </section>
            <section className='flex flex-col gap-12 w-2/3'>
                <span>First name and Second name: {userData.firstName} {userData.secondName}</span>
                <span>Birthday: {userData.birthday}</span>
                <span>Sector</span>
                <span>Position</span>
                <span>workplace</span>
                <span>Start date</span>
            </section>
        </div>
    </main>
  )
}

import LogoutButton from '@/components/ui/logout-button'
import React from 'react'

export default function Page() {

    return (
        <section className="flex flex-col items-center w-full h-screen p-4">
            <h1 className="text-3xl font-bold italic">Settings</h1>
            <LogoutButton/>
        </section>
  )
}

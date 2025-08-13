import VacationRequest from '@/components/form/vacation_request'
import React from 'react'

export default function Page() {

    return (
        <section className="flex flex-col items-center w-full h-screen p-4">
            <h1 className="text-3xl font-bold italic">Vacation Request</h1>
            <VacationRequest />
        </section>
  )
}

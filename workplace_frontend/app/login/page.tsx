import React from 'react'
import Login from '@/components/login';

export default function Page() {
  return (
    <main className="font-sans grid grid-rows-[20px_1fr_20px] items-center justify-items-center min-h-screen p-8 pb-20 gap-16 sm:p-20 bg-linear-to-r/oklab from-indigo-500 to-teal-400">
        <h1 className="text-3xl font-bold italic">Workplace</h1>
        <Login/>
    </main>
  )
}

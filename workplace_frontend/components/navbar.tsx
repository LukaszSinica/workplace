import Link from 'next/link'
import React from 'react'

export default function Navbar() {
  return (
    <nav className="flex flex-col border-2 border-black w-1/4 h-screen items-center">
        <span className="mt-6 mb-12 font-bold text-2xl">Nav</span>
        <Link className=" w-1/2 border-2 text-center p-2 font-semibold text-xl" href="/profile">
            Profile
        </Link>
        <Link className=" w-1/2 border-2 text-center p-2 font-semibold text-xl" href="/vacation_request">
            Vacation Request
        </Link>
    </nav>
  )
}

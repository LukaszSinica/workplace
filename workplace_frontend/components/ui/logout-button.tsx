"use client"
import React from 'react'
import { Button } from './button'
import { signOut } from '@/lib/actions';
import { useRouter } from 'next/navigation'
import { useAuth } from '@/app/AuthContext';

export default function LogoutButton() {
    const router = useRouter();
    const { logout } = useAuth();

    const handleLogout = async () => {
      await signOut();
      logout()
      router.push("/login"); 
    };

    return (
        <Button type="button" className="mt-4" onClick={handleLogout}>Logout</Button>
    )
}

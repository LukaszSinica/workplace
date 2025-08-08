"use client"
import React from 'react'
import { Button } from '@/components/ui/button'
import Link from 'next/link'
import { Input } from '@/components/ui/input'
import { useForm } from 'react-hook-form'
import { useAuth } from '@/app/AuthContext'

type LoginData = {
    email: string;
    password: string;
} 

export default function login() {
    const { register, formState: { errors }, handleSubmit } = useForm<LoginData>();
    const { login } = useAuth();

    const onSubmit = (data: LoginData) => {
        console.log("Login data submitted:", data);
        login(data.email, data.password)
            .then((success) => {
                if (success) {
                    console.log("Login successful");
                } else {
                    console.error("Login failed");
                }
            })
    }

    return (
        <section className="bg-white shadow-md rounded-lg p-6 max-w-md w-full">
            <form onSubmit={handleSubmit(onSubmit)}>
                <h2 className="font-medium pb-8 pt-2 text-xl">Enter your login credentials</h2>
                <div className="mb-4">
                    <label htmlFor="email" className="block text-sm font-medium text-gray-700">Email</label>
                    <Input 
                        type="email" 
                        {...register("email", 
                            {
                                required: true,
                                pattern: /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                            })} 
                        className="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                        />
                    {errors.email && 
                        <span>Enter a valid email</span>
                    }
                </div>
                <div className="">
                    <label htmlFor="password" className="block text-sm font-medium text-gray-700">Password</label>
                    <Input type="password" {...register("password", {required: true})} className="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                    {errors.password && 
                        <span>Enter a valid password</span>
                    }
                </div>
                <div className='mb-12'>
                    <Link href="" className="text-sm text-sky-500 hover:text-sky-600">
                        Forgot password?
                    </Link>
                </div>
                <Button type="submit" className="w-full text-white font-semibold py-2 px-4 rounded bg-gradient-to-r from-sky-300 to-sky-500 hover:from-sky-600 hover:cursor-pointer">Login</Button>
            </form>
        </section>
    )
}

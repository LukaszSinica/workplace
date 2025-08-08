"use client"
import React from 'react'
import { useForm } from 'react-hook-form';
import { Input } from '@/components/ui/input';
import { Textarea } from '@/components/ui/textarea';
import { Button } from '@/components/ui/button';
import { vacationRequestCreate } from '@/lib/actions';

type VacationRequestData = {
    date_from: string;
    date_to: string;
    reason: string;
} 

export default function VacationRequest() {
    const { register, handleSubmit, formState: { errors } } = useForm<VacationRequestData>();
    
    const onSubmit = (vacationRequestData: VacationRequestData) => {
        vacationRequestCreate(vacationRequestData)
        .then((success) => {
            if (success) {
                console.log(" Vacation request submitted successfully", vacationRequestData);
            } else {
                console.error(" Vacation request submission failed");
            }
        })
    }

    return (
        <form className="flex flex-col gap-4" onSubmit={handleSubmit(onSubmit)}>
            <label>
            Start Date:
            <Input type="date" {...register("date_from")} required className="border p-2 rounded" />
            </label>
            <label>
            End Date:
            <Input type="date" {...register("date_to")} required className="border p-2 rounded"/>
            </label>
            <label>
            Reason:
            <Textarea {...register("reason")} required className="border p-2 rounded"></Textarea>
            </label>
            <Button type="submit" className="bg-blue-500 text-white p-2 rounded">Submit Request</Button>
        </form>
    )
}

import { vacationRequestList } from '@/lib/actions';
import React from 'react'
import { DataTable } from './data-table';
import { columns, VacationRequest } from './columns';


async function getData(): Promise<VacationRequest[]> {
  const response = await vacationRequestList();
  if (!response || !response.vacation_request) {
    throw new Error('Failed to fetch vacation requests');
  }
  return response.vacation_request;
}

export default async function Page() {
  const vacationList = await getData();
  console.log(vacationList);
  return (
    <div className="container mx-auto py-10">
      {/* <DataTable columns={columns} data={vacationList.vacation_request} /> */}
    </div>
  )
}

import { vacationRequestList } from '@/lib/actions';
import React from 'react'
import { DataTable } from './data-table';
import { columns } from './columns';


export default async function Page() {
  const data = await vacationRequestList();
  const vacationRequest = data.vacation_requests;

  return (
    <div className="container mx-auto py-10">
      <DataTable columns={columns} data={vacationRequest} />
    </div>
  )
}

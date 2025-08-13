"use client"

import { ColumnDef } from "@tanstack/react-table"

// This type is used to define the shape of our data.
// You can use a Zod schema here if you want.
export type VacationRequest = {
  id: string
  date_from: String
  date_to: String
  reason: string
}

export const columns: ColumnDef<VacationRequest>[] = [
  {
    accessorKey: "date_from",
    header: "Date From",
  },
  {
    accessorKey: "date_to",
    header: "Date To",
  },
  {
    accessorKey: "reason",
    header: "Reason",
  },
]
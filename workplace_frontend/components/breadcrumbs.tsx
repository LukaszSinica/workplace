"use client"
import React from 'react'
import { Breadcrumb, BreadcrumbItem, BreadcrumbLink, BreadcrumbList, BreadcrumbPage, BreadcrumbSeparator } from './ui/breadcrumb'
import { usePathname } from 'next/navigation'
import Link from 'next/link'

export default function Breadcrumbs() {
    const pathname = usePathname()
    const segments = pathname.split("/").filter(Boolean)
    if (segments.length === 0) {
      return null; 
    }

    const hasPage = (href: string) => {
      const allowedPaths = ["/", "/vacation/request", "/vacation/list", "/vacation/view"]
      return allowedPaths.includes(href)
    }

    return (
      <Breadcrumb>
        <BreadcrumbList>
          <BreadcrumbItem>
            <BreadcrumbLink asChild>
              <Link href="/">Home</Link>
            </BreadcrumbLink>
          </BreadcrumbItem>
  
          {segments.map((segment, index) => {
            const href = "/" + segments.slice(0, index + 1).join("/")
            const isLast = index === segments.length - 1
            const label = segment.charAt(0).toUpperCase() + segment.slice(1)
  
            return (
              <React.Fragment key={href}>
                <BreadcrumbSeparator />
                <BreadcrumbItem>
                  {isLast || !hasPage(href) ? (
                    <BreadcrumbPage>{label}</BreadcrumbPage>
                  ) : (
                    <BreadcrumbLink asChild>
                      <Link href={href}>{label}</Link>
                    </BreadcrumbLink>
                  )}
                </BreadcrumbItem>
              </React.Fragment>
            )
          })}
        </BreadcrumbList>
      </Breadcrumb>
    )
  }
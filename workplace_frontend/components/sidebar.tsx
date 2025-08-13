"use client"

import { useState } from "react"
import {
  Sidebar,
  SidebarContent,
  SidebarGroup,
  SidebarGroupContent,
  SidebarGroupLabel,
  SidebarMenu,
  SidebarMenuButton,
  SidebarMenuItem,
  SidebarMenuSub,
  SidebarMenuSubItem,
  SidebarMenuSubButton,
} from "@/components/ui/sidebar"
import { ChevronDown } from "lucide-react"

const items = [
  { title: "Profile", url: "/profile" },
  {
    title: "Vacation",
    children: [
      { title: "Request", url: "/vacation/request" },
      { title: "List", url: "/vacation/list" },
      { title: "View", url: "/vacation/view" },
    ],
  },
  { title: "Calendar", url: "#" },
  { title: "Search", url: "#" },
  { title: "Settings", url: "/settings" },
]

export function AppSidebar() {
  const [openDropdown, setOpenDropdown] = useState<string | null>(null)

  const toggleDropdown = (title: string) => {
    setOpenDropdown(openDropdown === title ? null : title)
  }
  
  return (
    <Sidebar>
      <SidebarContent>
        <SidebarGroup>
          <SidebarGroupLabel>Workplace</SidebarGroupLabel>
          <SidebarGroupContent>
            <SidebarMenu>
              {items.map((item) =>
                item.children ? (
                  <SidebarMenuItem key={item.title}>
                    <SidebarMenuButton
                      onClick={() => toggleDropdown(item.title)}
                      className="flex w-full items-center justify-between"
                    >
                      <span>{item.title}</span>
                      <ChevronDown
                        className={`h-4 w-4 transition-transform ${
                          openDropdown === item.title ? "rotate-180" : ""
                        }`}
                      />
                    </SidebarMenuButton>

                    {openDropdown === item.title && (
                      <SidebarMenuSub>
                        {item.children.map((child) => (
                          <SidebarMenuSubItem key={child.title}>
                            <SidebarMenuSubButton asChild>
                              <a href={child.url}>{child.title}</a>
                            </SidebarMenuSubButton>
                          </SidebarMenuSubItem>
                        ))}
                      </SidebarMenuSub>
                    )}
                  </SidebarMenuItem>
                ) : (
                  <SidebarMenuItem key={item.title}>
                    <SidebarMenuButton asChild>
                      <a href={item.url}>
                        <span>{item.title}</span>
                      </a>
                    </SidebarMenuButton>
                  </SidebarMenuItem>
                )
              )}
            </SidebarMenu>
          </SidebarGroupContent>
        </SidebarGroup>
      </SidebarContent>
    </Sidebar>
  )
}
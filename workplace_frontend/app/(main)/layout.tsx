import Navbar from "@/components/navbar";
import { AppSidebar } from "@/components/sidebar";
import { SidebarProvider, SidebarTrigger } from "@/components/ui/sidebar";

export default function MainLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  return (
    <SidebarProvider>
    <main className="flex flex-row h-screen w-full items-center">
      <AppSidebar />
      <section className="flex flex-col items-center w-full h-screen">
        <nav className="w-full h-16 bg-white shadow-md flex items-center justify-between">
          <SidebarTrigger />
        </nav>
        {children}
      </section>
    </main>
    </SidebarProvider>
  );
}

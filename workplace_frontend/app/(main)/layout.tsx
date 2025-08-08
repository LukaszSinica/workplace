import Navbar from "@/components/navbar";

export default function MainLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  return (
    <main className="flex flex-row h-screen">
      <Navbar/>
      <section className="flex flex-col items-center w-3/4 h-screen border-2 border-black">
        {children}
      </section>
    </main>
  );
}

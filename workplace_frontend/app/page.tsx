import Link from "next/link";

export default function Home() {
  
  return (
    <main className="flex flex-row h-screen">
      <nav className="flex flex-col border-2 border-black w-1/4 h-screen items-center">
        <span className="mt-6 mb-12 font-bold text-2xl">Nav</span>
        <Link className=" w-1/2 border-2 text-center p-2 font-semibold text-xl" href="/profile">Profile</Link>
      </nav>
      <section className="flex flex-col items-center w-3/4 h-screen border-2 border-black">
        <span className="mt-6 mb-12 font-bold text-3xl">Notifications</span>
      </section>
    </main>
  );
}

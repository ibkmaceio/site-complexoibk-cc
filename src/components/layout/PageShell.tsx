import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";

export default function PageShell({ children }: { children: React.ReactNode }) {
  return (
    <>
      <Header />
      <main className="pt-20 min-h-screen bg-[#0a0a0a]">{children}</main>
      <Footer />
    </>
  );
}

import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";

export default function PageShell({ children }: { children: React.ReactNode }) {
  return (
    <>
      <Header />
      <main id="main-content" className="min-h-screen bg-[#222222] pt-16 lg:pt-20">{children}</main>
      <Footer />
    </>
  );
}

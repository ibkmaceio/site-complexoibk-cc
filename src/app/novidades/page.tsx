import type { Metadata } from "next";
import PageShell from "@/components/layout/PageShell";
import NoticiasSection from "@/components/sections/NoticiasSection";

export const metadata: Metadata = {
  title: "Novidades",
  description: "Fique por dentro das notícias, eventos e histórias de transformação da Igreja Batista Koinonia em Maceió, Alagoas.",
};

export default function NoticiasPage() {
  return (
    <PageShell>
      <NoticiasSection />
    </PageShell>
  );
}

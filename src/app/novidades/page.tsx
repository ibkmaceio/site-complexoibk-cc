import type { Metadata } from "next";
import PageShell from "@/components/layout/PageShell";
import NoticiasSection from "@/components/sections/NoticiasSection";

export const metadata: Metadata = {
  title: "Novidades",
  description: "Notícias, eventos e novidades da Igreja Batista Koinonia em Maceió.",
};

export default function NoticiasPage() {
  return (
    <PageShell>
      <NoticiasSection />
    </PageShell>
  );
}

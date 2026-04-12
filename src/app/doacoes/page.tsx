import type { Metadata } from "next";
import PageShell from "@/components/layout/PageShell";
import DoacoesSection from "@/components/sections/DoacoesSection";

export const metadata: Metadata = {
  title: "Dízimos e Ofertas",
  description: "Contribua com a obra de Deus na Igreja Batista Koinonia em Maceió — PIX e dados bancários.",
};

export default function DoacoesPage() {
  return (
    <PageShell>
      <DoacoesSection />
    </PageShell>
  );
}

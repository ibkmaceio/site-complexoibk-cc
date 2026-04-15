import type { Metadata } from "next";
import PageShell from "@/components/layout/PageShell";
import DoacoesSection from "@/components/sections/DoacoesSection";

export const metadata: Metadata = {
  title: "Dízimos e Ofertas",
  description: "Contribua com a missão da IBK Maceió via PIX ou depósito bancário. Seja parte do que Deus está fazendo em Maceió, AL.",
};

export default function DoacoesPage() {
  return (
    <PageShell>
      <DoacoesSection />
    </PageShell>
  );
}

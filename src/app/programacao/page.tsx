import type { Metadata } from "next";
import PageShell from "@/components/layout/PageShell";
import ProgramacaoSection from "@/components/sections/ProgramacaoSection";

export const metadata: Metadata = {
  title: "Programação",
  description: "Horários dos cultos da IBK Maceió: domingos às 9h e 18h30, quartas às 19h30 e sábados às 18h. Você e sua família são sempre bem-vindos!",
};

export default function ProgramacaoPage() {
  return (
    <PageShell>
      <ProgramacaoSection />
    </PageShell>
  );
}

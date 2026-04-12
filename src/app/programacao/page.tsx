import type { Metadata } from "next";
import PageShell from "@/components/layout/PageShell";
import ProgramacaoSection from "@/components/sections/ProgramacaoSection";

export const metadata: Metadata = {
  title: "Programação",
  description: "Horários dos cultos e programação semanal da Igreja Batista Koinonia em Maceió.",
};

export default function ProgramacaoPage() {
  return (
    <PageShell>
      <ProgramacaoSection />
    </PageShell>
  );
}

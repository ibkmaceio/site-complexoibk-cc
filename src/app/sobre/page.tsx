import type { Metadata } from "next";
import PageShell from "@/components/layout/PageShell";
import SobreSection from "@/components/sections/SobreSection";

export const metadata: Metadata = {
  title: "Sobre a IBK",
  description: "Conheça a Igreja Batista Koinonia em Maceió — missão, visão, valores e quem somos.",
};

export default function SobrePage() {
  return (
    <PageShell>
      <SobreSection />
    </PageShell>
  );
}
